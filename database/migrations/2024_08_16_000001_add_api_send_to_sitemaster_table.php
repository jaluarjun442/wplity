<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApiSendToSiteMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_master', function (Blueprint $table) {
            $table->timestamp('last_updated_api_send')->nullable();
            $table->string('api_send_url')->nullable();
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
            $table->dropColumn('last_updated_api_send');
            $table->dropColumn('api_send_url');
        });
    }
}
