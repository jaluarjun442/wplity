<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();
            $table->string('site_url')->nullable();
            $table->string('site_logo')->nullable();
            $table->string('site_type')->default('multi_site')->nullable();
            $table->string('default_site_id')->nullable();
            $table->text('header_script')->nullable();
            $table->text('footer_script')->nullable();
            $table->text('header_style')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting');
    }
}
