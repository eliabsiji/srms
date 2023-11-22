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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')
                                        ->on('users')->onUpdate('cascade')
                                        ->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('paperid')->nullable();
            $table->string('categoryid')->nullable();
            $table->string('reviewerid')->nullable();
            $table->string('pending')->nullable();
            $table->string('underreview')->nullable();
            $table->string('rejected')->nullable();
            $table->string('accepted')->nullable();
            $table->string('published')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
