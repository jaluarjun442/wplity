<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThumbnailDisplayToSiteMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_master', function (Blueprint $table) {
            $table->string('thumbnail_display')->default('true')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_master', function (Blueprint $table) {
            $table->dropColumn('thumbnail_display');
        });
    }
}
