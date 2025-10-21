<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->text('address')->nullable()->after('phone');
            $table->string('image')->nullable()->after('address');
            $table->string('twitter_link')->nullable()->after('image');
            $table->string('fb_link')->nullable()->after('twitter_link');
            $table->string('insta_link')->nullable()->after('fb_link');
            $table->string('github_link')->nullable()->after('insta_link');
            $table->string('portfolio_link')->nullable()->after('github_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};