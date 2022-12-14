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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('publisher_id')->nullable()->constrained()->nullOnDelete();

            $table->unsignedBigInteger('itemable_id');
            $table->string('itemable_type');

            $table->string('title');
            $table->year('published_at')->nullable();
            $table->text('thumbnail')->nullable();
            $table->text('comment')->nullable();

            $table->timestamps();

            $table->unique(['itemable_id', 'itemable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
