<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_task_images', function (Blueprint $table) {
            $table->longText('image_preview_url')->nullable()->after('image_title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_task_images', function (Blueprint $table) {
            $table->dropColumn('image_preview_url');
        });
    }
};
