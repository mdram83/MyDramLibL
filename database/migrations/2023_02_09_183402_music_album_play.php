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
        Schema::table('music_albums', function (Blueprint $table) {
            $table->string('links')->nullable();
            $table->smallInteger('play_count')->default(0);
            $table->timestamp('played_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('music_albums', function (Blueprint $table) {
            $table->dropColumn('links');
            $table->dropColumn('play_count');
            $table->dropColumn('played_on');
        });
    }
};
