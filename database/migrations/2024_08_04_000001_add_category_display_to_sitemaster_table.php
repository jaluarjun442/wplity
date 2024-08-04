<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryDisplayToSiteMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_master', function (Blueprint $table) {
            $table->text('category')->nullable();
            $table->string('category_display')->default('false')->nullable();
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
            $table->dropColumn('category');
            $table->dropColumn('category_display');
        });
    }
}
