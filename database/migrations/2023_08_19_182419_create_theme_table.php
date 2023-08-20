<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('description', 255);
            $table->unsignedBigInteger('channel_id');
            $table->text('images');
            $table->boolean('is_deleted')->nullable();
            $table->boolean('is_archive')->nullable();
            $table->integer('comments_active')->nullable();
            $table->integer('likes')->default(0);
            $table->integer('comments_count')->default(0);
            $table->unsignedBigInteger('repost_id')->nullable();
            $table->timestamps();

            $table->foreign('channel_id')->references('id')->on('channel');
            $table->foreign('repost_id')->references('id')->on('theme');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme');
    }
};
