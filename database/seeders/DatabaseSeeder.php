<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // default setting start
        Setting::create([
            'site_name' => "",
            'site_url' => "",
            'site_logo' => "",
            'site_type' => "",
            'default_site_id' => "",
            'header_script' => "",
            'footer_script' => "",
            'header_style' => "",
            'status' => true
        ]);
        // default setting end
    }
}
