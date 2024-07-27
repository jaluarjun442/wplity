<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Sitemap;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;


class GenerateSitemap extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:generate_sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate_sitemap';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function handle()
    {
        ini_set('max_execution_time', 0);
        $sitemap_id = Sitemap::max('id');
        $sitemap_id =  $sitemap_id ? $sitemap_id + 1 : 1;
        $sitemap_name = 'sitemap_' . $sitemap_id . '_' . Carbon::now()->format('Ymd_His');
        $per_page = 1000;
        $start = 1;
        $end = 40;
        $sitemapPath = 'sitemap/' . $sitemap_name . '.xml';
        $this->line("Sitemap Name===>" . $sitemap_name);
        $sitemap_data = SitemapGenerator::create('')
            ->getSitemap();
        $total_added = 0;
        for ($page = $start; $page <= $end; $page++) {
            $urls = $this->generateUrls($page, $per_page);
            $total_added = $total_added + count($urls);
            if (count($urls) > 0) {
                $sitemap_data->add($urls);
                $this->line('=====Page====>' . $page . '<========>(' . count($urls) . ' posts)<====');
            }
        }
        if ($total_added > 0) {
            $sitemap_data->writeToFile($sitemapPath);
            $created_sitemap = Sitemap::create([
                'name' => $sitemap_name,
                'notes' => 'Success',
                'total_post_added' => $total_added
            ]);
        }
        $this->line("Completed===>Total===>" . $total_added);
    }
    public function generateUrls($page, $per_page)
    {
        ini_set('max_execution_time', 0);
        $urls = [];
        $posts = Post::where('sitemap_added', 0)->orderBy('id', 'asc')->limit($per_page)->get();
        foreach ($posts as $post) {
            $postId = $post['post_id'];
            $postSlug = $post['slug'];
            $url = '/' . $post->site_id . '/post/' . $postId . '/' . $postSlug;
            $urlObject = Url::create($url)->setPriority(0.6);
            $urls[] = $urlObject;

            $post->sitemap_added = 1;
            $post->save();
        }
        return $urls;
    }
}
