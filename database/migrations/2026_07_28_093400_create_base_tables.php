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
        // cache table
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->bigInteger('expiration')->index();
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->bigInteger('expiration')->index();
        });

        // jobs table
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedSmallInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('connection');
            $table->string('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();

            $table->index(['connection', 'queue', 'failed_at']);
        });

        // Users table
        Schema::create('user', function (Blueprint $table) {
            $table->id()->autoIncrement()->primary();
            $table->string('email', 50)->unique();
            $table->string('name', 30)->unique();
            $table->string('password', 64);
            $table->integer('role');
            $table->string('avatar', 255)->nullable();
        });


        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained('user')->onDelete('cascade')->onUpdate('restrict');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Recipes table
        Schema::create('recipe', function (Blueprint $table) {
            $table->id()->autoIncrement()->primary();
            $table->string('title', 100);
            $table->string('description', 1000);
            $table->string('thumbnail', 255)->nullable();
            $table->date('creation_date')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });

        // Foreign keys and indexes for recipe
        Schema::table('recipe', function (Blueprint $table) {
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('SET NULL')->onUpdate('RESTRICT');
        });

        // Ingredient table
        Schema::create('ingredient', function (Blueprint $table) {
            $table->id()->autoIncrement()->primary();
            $table->string('name', 50)->unique();
            $table->float('calories');
            $table->float('carbohydrate');
            $table->float('protein');
            $table->float('fat');
        });

        // Step table
        Schema::create('step', function (Blueprint $table) {
            $table->id()->autoIncrement()->primary();
            $table->string('description', 1000);
            $table->unsignedBigInteger('recipe_id');
            $table->integer('order');

            $table->foreign('recipe_id')->references('id')->on('recipe')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });

        // Unique constraint for step
        Schema::table('step', function (Blueprint $table) {
            $table->unique(['recipe_id', 'order']);
        });

        // Ingredient_Recipe table
        Schema::create('ingredient_recipe', function (Blueprint $table) {
            $table->id()->autoIncrement()->primary();
            $table->unsignedBigInteger('ingredient_id');
            $table->unsignedBigInteger('recipe_id');
            $table->float('quantity');
            $table->string('unit', 20);
        });

        Schema::table('ingredient_recipe', function (Blueprint $table) {
            $table->index('ingredient_id');
            $table->index('recipe_id');
            $table->foreign('ingredient_id')->references('id')->on('ingredient')->onDelete('CASCADE')->onUpdate('RESTRICT');
            $table->foreign('recipe_id')->references('id')->on('recipe')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });

        // Favorite table
        Schema::create('favorites', function (Blueprint $table) {
            $table->id()->autoIncrement()->primary();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('recipe_id');
            $table->timestamps();

            $table->unique(['user_id', 'recipe_id']);
        });

        Schema::table('favorites', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('user')->onDelete('CASCADE')->onUpdate('RESTRICT');
            $table->foreign('recipe_id')->references('id')->on('recipe')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });

        // Category tables
        Schema::create('meal_time', function (Blueprint $table) {
            $table->id()->autoIncrement()->primary();
            $table->string('name', 50);
            $table->string('thumbnail', 255)->nullable();
        });

        Schema::create('food_type', function (Blueprint $table) {
            $table->id()->autoIncrement()->primary();
            $table->string('name', 50);
            $table->string('thumbnail', 255)->nullable();
        });

        Schema::create('diet', function (Blueprint $table) {
            $table->id()->autoIncrement()->primary();
            $table->string('name', 50);
            $table->string('thumbnail', 255)->nullable();
        });

        Schema::create('allergen', function (Blueprint $table) {
            $table->id()->autoIncrement()->primary();
            $table->string('name', 50);
            $table->string('thumbnail', 255)->nullable();
        });

        Schema::create('cuisine', function (Blueprint $table) {
            $table->id()->autoIncrement()->primary();
            $table->string('name', 50);
            $table->string('thumbnail', 255)->nullable();
        });

        // Pivot tables
        Schema::create('meal_time_recipe', function (Blueprint $table) {
            $table->unsignedBigInteger('meal_time_id');
            $table->unsignedBigInteger('recipe_id');
            $table->primary(['meal_time_id', 'recipe_id']);
        });

        Schema::table('meal_time_recipe', function (Blueprint $table) {
            $table->foreign('meal_time_id')->references('id')->on('meal_time')->onDelete('CASCADE')->onUpdate('RESTRICT');
            $table->foreign('recipe_id')->references('id')->on('recipe')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });

        Schema::create('food_type_recipe', function (Blueprint $table) {
            $table->unsignedBigInteger('food_type_id');
            $table->unsignedBigInteger('recipe_id');
            $table->primary(['food_type_id', 'recipe_id']);
        });

        Schema::table('food_type_recipe', function (Blueprint $table) {
            $table->foreign('food_type_id')->references('id')->on('food_type')->onDelete('CASCADE')->onUpdate('RESTRICT');
            $table->foreign('recipe_id')->references('id')->on('recipe')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });

        Schema::create('diet_recipe', function (Blueprint $table) {
            $table->unsignedBigInteger('diet_id');
            $table->unsignedBigInteger('recipe_id');
            $table->primary(['diet_id', 'recipe_id']);
        });

        Schema::table('diet_recipe', function (Blueprint $table) {
            $table->foreign('diet_id')->references('id')->on('diet')->onDelete('CASCADE')->onUpdate('RESTRICT');
            $table->foreign('recipe_id')->references('id')->on('recipe')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });

        Schema::create('allergen_recipe', function (Blueprint $table) {
            $table->unsignedBigInteger('allergen_id');
            $table->unsignedBigInteger('recipe_id');
            $table->primary(['allergen_id', 'recipe_id']);
        });

        Schema::table('allergen_recipe', function (Blueprint $table) {
            $table->foreign('allergen_id')->references('id')->on('allergen')->onDelete('CASCADE')->onUpdate('RESTRICT');
            $table->foreign('recipe_id')->references('id')->on('recipe')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });

        Schema::create('cuisine_recipe', function (Blueprint $table) {
            $table->unsignedBigInteger('cuisine_id');
            $table->unsignedBigInteger('recipe_id');
            $table->primary(['cuisine_id', 'recipe_id']);
        });

        Schema::table('cuisine_recipe', function (Blueprint $table) {
            $table->foreign('cuisine_id')->references('id')->on('cuisine')->onDelete('CASCADE')->onUpdate('RESTRICT');
            $table->foreign('recipe_id')->references('id')->on('recipe')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('user');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('recipe');
        Schema::dropIfExists('ingredient');
        Schema::dropIfExists('step');
        Schema::dropIfExists('ingredient_recipe');
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('cuisine_recipe');
        Schema::dropIfExists('allergen_recipe');
        Schema::dropIfExists('diet_recipe');
        Schema::dropIfExists('food_type_recipe');
        Schema::dropIfExists('meal_time_recipe');
        Schema::dropIfExists('cuisine');
        Schema::dropIfExists('allergen');
        Schema::dropIfExists('diet');
        Schema::dropIfExists('food_type');
        Schema::dropIfExists('meal_time');
    }
};