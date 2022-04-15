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
        Schema::table('staff_tasks', function (Blueprint $table) {
            $table->enum('source', ['shutter stock', 'story blocks'])->nullable()->after('is_completed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_tasks', function (Blueprint $table) {
            $table->dropColumn('source');
        });
    }
};
