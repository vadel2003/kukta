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

        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('email', 254)->unique();
            $table->string('name', 30)->unique();
            $table->string('password', 255); // stored hashed
            $table->boolean('is_admin')->default(false); // super admin flag
            $table->string('avatar', 255)->nullable();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained('user')->onDelete('CASCADE');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('recipe', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('description', 1000);
            $table->unsignedSmallInteger('prep_time'); // preparation time in minutes
            $table->unsignedTinyInteger('difficulty'); // 0 = easy, 1 = medium, 2 = hard (Recipe::DIFFICULTIES)
            $table->unsignedTinyInteger('servings'); // number of servings
            $table->string('thumbnail', 255);
            $table->foreignId('user_id')->nullable()->constrained('user')->onDelete('SET NULL');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('ingredient', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->double('calories');     // kcal / 100 g
            $table->double('carbohydrate'); // g / 100 g
            $table->double('protein');      // g / 100 g
            $table->double('fat');          // g / 100 g
        });

        Schema::create('step_category', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('thumbnail', 255)->unique(); // image path, e.g. images/steps/cooking.svg
        });

        Schema::create('step', function (Blueprint $table) {
            $table->id();
            $table->string('description', 1000);
            $table->unsignedTinyInteger('position'); // order, starting from 1
            $table->foreignId('recipe_id')->constrained('recipe')->onDelete('CASCADE');
            $table->foreignId('step_category_id')->constrained('step_category')->onDelete('RESTRICT');

            $table->unique(['recipe_id', 'position']);
        });

        Schema::create('ingredient_recipe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id')->constrained('recipe')->onDelete('CASCADE');
            $table->foreignId('ingredient_id')->constrained('ingredient')->onDelete('RESTRICT');
            $table->double('quantity');
            $table->unsignedTinyInteger('unit'); // unit number (IngredientRecipe::UNITS), e.g. 0 = g
        });

        Schema::create('favorite', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->onDelete('CASCADE');
            $table->foreignId('recipe_id')->constrained('recipe')->onDelete('CASCADE');
            $table->timestamps();

            $table->unique(['user_id', 'recipe_id']);
        });

        Schema::create('rating', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->onDelete('CASCADE');
            $table->foreignId('recipe_id')->constrained('recipe')->onDelete('CASCADE');
            $table->unsignedTinyInteger('score'); // 1-5

            $table->unique(['user_id', 'recipe_id']);
        });

        Schema::create('meal_time', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
        });

        Schema::create('food_type', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
        });

        Schema::create('diet', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
        });

        Schema::create('cuisine', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
        });

        Schema::create('free_from', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('label', 30); // shown on the recipe page, e.g. "Gluténmentes"
            $table->string('thumbnail', 255);
        });

        Schema::create('meal_time_recipe', function (Blueprint $table) {
            $table->foreignId('meal_time_id')->constrained('meal_time')->onDelete('CASCADE');
            $table->foreignId('recipe_id')->constrained('recipe')->onDelete('CASCADE');
            $table->primary(['meal_time_id', 'recipe_id']);
        });

        Schema::create('food_type_recipe', function (Blueprint $table) {
            $table->foreignId('food_type_id')->constrained('food_type')->onDelete('CASCADE');
            $table->foreignId('recipe_id')->constrained('recipe')->onDelete('CASCADE');
            $table->primary(['food_type_id', 'recipe_id']);
        });

        Schema::create('diet_recipe', function (Blueprint $table) {
            $table->foreignId('diet_id')->constrained('diet')->onDelete('CASCADE');
            $table->foreignId('recipe_id')->constrained('recipe')->onDelete('CASCADE');
            $table->primary(['diet_id', 'recipe_id']);
        });

        Schema::create('cuisine_recipe', function (Blueprint $table) {
            $table->foreignId('cuisine_id')->constrained('cuisine')->onDelete('CASCADE');
            $table->foreignId('recipe_id')->constrained('recipe')->onDelete('CASCADE');
            $table->primary(['cuisine_id', 'recipe_id']);
        });

        Schema::create('free_from_recipe', function (Blueprint $table) {
            $table->foreignId('free_from_id')->constrained('free_from')->onDelete('CASCADE');
            $table->foreignId('recipe_id')->constrained('recipe')->onDelete('CASCADE');
            $table->primary(['free_from_id', 'recipe_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('free_from_recipe');
        Schema::dropIfExists('cuisine_recipe');
        Schema::dropIfExists('diet_recipe');
        Schema::dropIfExists('food_type_recipe');
        Schema::dropIfExists('meal_time_recipe');
        Schema::dropIfExists('free_from');
        Schema::dropIfExists('cuisine');
        Schema::dropIfExists('diet');
        Schema::dropIfExists('food_type');
        Schema::dropIfExists('meal_time');
        Schema::dropIfExists('rating');
        Schema::dropIfExists('favorite');
        Schema::dropIfExists('ingredient_recipe');
        Schema::dropIfExists('step');
        Schema::dropIfExists('step_category');
        Schema::dropIfExists('ingredient');
        Schema::dropIfExists('recipe');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('user');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
    }
};
