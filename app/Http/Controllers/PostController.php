<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Setting;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $setting = Setting::first();
        if ($setting['site_type'] == 'multi_site') {
            ini_set('max_execution_time', 0);
            $sites = Site::where('status', 1)->get();
            return view('posts.index', compact('sites'));
        }
        if ($setting['site_type'] == 'single_site') {
            $site_id = $setting['default_site_id'];
            $default_site_data = Site::where('id', $site_id)->first();
            return $this->site_index($site_id, Str::slug($default_site_data['name']), 1, 'single_site');
        }
    }
    public function site_index($site_id, $site_slug, $page = 1, $site_type = 'multi_site')
    {
        ini_set('max_execution_time', 0);
        $perPage = 10;
        $site = Site::where('id', $site_id)->first();
        $site_url = $site->url;
        $apiUrl = $site->url . "/wp-json/wp/v2/posts?orderby=id&order=desc&per_page={$perPage}&page={$page}&_embed";
        $response = Http::get($apiUrl);
        if ($response->failed()) {
            abort(500, 'Error fetching posts from the API.');
        }
        $posts = $response->json();
        $total = $response->header('X-WP-Total');
        if ($site_type == 'single_site') {
            $paginator = new LengthAwarePaginator($posts, $total, $perPage, $page, [
                'path' => route('posts.home', ['site_id' => $site_id, 'site_slug' => $site_slug]),
                'pageName' => 'page',
            ]);
        } 
        if ($site_type == 'multi_site') {
            $paginator = new LengthAwarePaginator($posts, $total, $perPage, $page, [
                'path' => route('posts.site_index', ['site_id' => $site_id, 'site_slug' => $site_slug]),
                'pageName' => 'page',
            ]);
        }
        return view('posts.site_index', compact('paginator', 'site_id', 'site_slug','site_url'));
    }

    public function show($site_id, $id, $slug)
    {
        ini_set('max_execution_time', 0);
        $site = Site::where('id', $site_id)->first();
        $site_url = $site->url;
        $apiUrl = $site_url . "/wp-json/wp/v2/posts/{$id}";
        $response = Http::get($apiUrl);
        if ($response->failed()) {
            $post = [];
            return view('posts.show', compact('post'));
        }
        $post = $response->json();
        $post['content']['rendered'] = $this->replaceImageUrls($post['content']['rendered'], $site_id, $site_url);
        $post['content']['rendered'] = $this->rewrite($post['content']['rendered']);
        return view('posts.show', compact('post'));
    }
    private function rewrite($content)
    {
        ini_set('max_execution_time', 0);
        $synonyms = $this->loadSynonyms();
        $words = explode(' ', $content);
        $rewrittenWords = array_map(function ($word) use ($synonyms) {
            return $this->getSynonym($word, $synonyms);
        }, $words);

        return implode(' ', $rewrittenWords);
    }
    function loadSynonyms()
    {
        ini_set('max_execution_time', 0);
        return Helper::loadSynonyms();
    }

    function getSynonym($word, $synonyms)
    {
        ini_set('max_execution_time', 0);
        return array_key_exists($word, $synonyms) ? $synonyms[$word] : $word;
    }
    private function replaceImageUrls($content, $site_id, $site_url)
    {
        $originalUrl = $site_url . '/wp-content/uploads/';
        $localUrl = url('/') . '/' . $site_id . '/uploads/';
        return str_replace($originalUrl, $localUrl, $content);
    }
}
