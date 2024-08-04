<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Site;
use DataTables;
use Illuminate\Support\Facades\Storage;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Site::latest()->get();
            return DataTables::of($data)
                ->addColumn('image', function ($row) {
                    return "<img src='" . asset('uploads/site') . '/' . $row['image'] . "' style='width:100px; height:100px;' />";
                })
                ->addColumn('action', function ($row) {
                    $fetchUrl = route('sites.fetch', $row->id);
                    $editUrl = route('sites.edit', $row->id);
                    $deleteUrl = route('sites.destroy', $row->id);

                    $btn = '<a href="' . $fetchUrl . '" class="edit btn btn-info btn-sm">Fetch</a> ';
                    $btn .= '<a href="' . $editUrl . '" class="edit btn btn-primary btn-sm">Edit</a> ';
                    $btn .= '<a href="' . $deleteUrl . '" class="delete btn btn-danger btn-sm" onclick="event.preventDefault(); 
                             if(confirm(\'Are you sure you want to delete this site?\')) 
                                 document.getElementById(\'delete-form-' . $row->id . '\').submit();">Delete</a>';

                    $btn .= '<form id="delete-form-' . $row->id . '" action="' . $deleteUrl . '" method="POST" style="display: none;">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                             </form>';

                    return $btn;
                })
                ->addColumn('status', function ($row) {
                    return $row->status == 1 ? 'Active' : 'Inactive';
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('sites.index');
    }

    public function create()
    {
        return view('sites.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|string|max:255',
            'status' => 'required|boolean',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image = $request->post('name') . rand(1111111111, 9999999999) . "." . $file->getClientOriginalExtension();
            $file->move("uploads/site/", $image);
        } else {
            $image = "sample.jpg";
        }
        $site = Site::create([
            'name' => $request->name,
            'description' => $request->description,
            'last_id' => $request->last_id,
            'last_updated_fetch' => $request->last_updated_fetch,
            'total_post' => '0',
            'url' => $request->url,
            'status' => $request->status,
            'thumbnail_display' => $request->thumbnail_display,
            'category_display' => $request->category_display,
            'image' => $image,
        ]);
        $category_data = Helper::store_categories($site->id);
        $site->category = json_encode($category_data);
        $site->save();
        return redirect()->route('sites.index')->with('success', 'site created successfully.');
    }

    public function edit(site $site)
    {
        return view('sites.edit', compact('site'));
    }
    public function fetch($id)
    {
        $site = Site::where('id', $id)->first();
        return view('sites.fetch', compact('site'));
    }

    public function fetch_data(Request $request)
    {
        ini_set('max_execution_time', 0);
        $site_id = $request->id;
        $site = Site::where('id', $site_id)->first();
        $last_updated_fetch = $site->last_updated_fetch;
        $last_updated_fetch_encoded = urlencode($site->last_updated_fetch);
        $site_url = $site->url;
        $per_page = 100;
        $page = 1;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $site_url . '/wp-json/wp/v2/posts?orderby=date&order=asc&after=' . $last_updated_fetch_encoded . '&per_page=' . $per_page . '&page=' . $page,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HEADER => true,
            CURLOPT_REFERER => '',
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        curl_close($curl);

        $headers = [];
        $data = explode("\r\n", $header);
        foreach ($data as $part) {
            $middle = explode(":", $part);
            if (isset($middle[1])) {
                $headers[trim($middle[0])] = trim($middle[1]);
            }
        }

        $posts = json_decode($body);
        if ($err) {
            return response()->json(['status' => false, 'message' => 'Curl Error: ' . $err]);
        } else {
            if (count($posts) > 0) {

                foreach ($posts as $post) {
                    $created_post = Post::create([
                        'site_id' => $site_id,
                        'post_id' => $post->id,
                        'slug' => $post->slug
                    ]);
                    $last_updated_fetch = $post->date;
                }
                $site = Site::findOrFail($site_id);
                $site->last_updated_fetch = $last_updated_fetch;
                $site->save();
                return response()->json([
                    'status' => true,
                    'message' => count($posts) . ' Post Fetched => Success.',
                    'total_post' => $headers['X-WP-Total'] ?? null,
                    'total_pages' => $headers['X-WP-TotalPages'] ?? null,
                    'current_page' => $page,
                    'last_updated_fetch' => $last_updated_fetch,
                    'next_page' => $headers['X-WP-TotalPages'] == $page ? false : true
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'No Updated Post Available.',
                    'total_post' => $headers['X-WP-Total'] ?? null,
                    'total_pages' => $headers['X-WP-TotalPages'] ?? null,
                    'current_page' => $page,
                    'last_updated_fetch' => $last_updated_fetch,
                    'next_page' => false
                ]);
            }
        }
    }

    public function update(Request $request, $id)
    {
        $site = Site::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|string|max:255',
            'status' => 'required|boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($site->image) {
                Storage::delete('uploads/site/' . $site->image);
            }

            $file = $request->file('image');
            $image = $request->name . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move("uploads/site/", $image);

            $site->image = $image;
        }

        $category_data = Helper::get_categories($id);
        $site->name = $request->name;
        $site->description = $request->description;
        $site->last_updated_fetch = $request->last_updated_fetch;
        $site->last_id = $request->last_id;
        $site->total_post = $request->total_post;
        $site->url = $request->url;
        $site->status = $request->status;
        $site->thumbnail_display = $request->thumbnail_display;
        $site->category_display = $request->category_display;
        $site->category = json_encode($category_data);
        $site->save();

        return redirect()->route('sites.index')->with('success', 'site updated successfully.');
    }

    public function destroy(site $site)
    {
        $site->delete();

        return redirect()->route('sites.index')
            ->with('success', 'site deleted successfully.');
    }
}
