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
            $table->id();
            $table->string('email', 254)->unique();
            $table->string('name', 30)->unique();
            $table->string('password', 255); // hash-elve tárolva
            $table->boolean('is_admin')->default(false); // szuperadmin jogot kézzel kell beállítani
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
            $table->id();
            $table->string('title', 100);
            $table->string('description', 1000);
            $table->unsignedSmallInteger('prep_time'); // elkészítési idő percben
            $table->unsignedTinyInteger('difficulty'); // 0 = könnyű, 1 = közepes, 2 = nehéz (Recipe::DIFFICULTIES)
            $table->unsignedTinyInteger('servings'); // adag
            $table->string('thumbnail', 255);
            $table->foreignId('user_id')->nullable()->constrained('user')->onDelete('SET NULL')->onUpdate('RESTRICT');
            // A timestamps() üresen hagyható oszlopokat hozna létre, ezért kézzel, kötelezőként
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        // Ingredient table (tápértékek 100 g-ra)
        Schema::create('ingredient', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->double('calories');     // kcal
            $table->double('carbohydrate'); // g
            $table->double('protein');      // g
            $table->double('fat');          // g
        });

        // Step category table
        Schema::create('step_category', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('gif_filename', 255)->unique(); // a public/lottie mappában lévő animáció fájlneve
        });

        // Step table
        Schema::create('step', function (Blueprint $table) {
            $table->id();
            $table->string('description', 1000);
            // "position" és nem "order": az order SQL-ben foglalt szó (ORDER BY)
            $table->unsignedTinyInteger('position'); // sorszám, 1-től
            $table->foreignId('recipe_id')->constrained('recipe')->onDelete('CASCADE')->onUpdate('RESTRICT');
            $table->foreignId('step_category_id')->constrained('step_category')->onDelete('RESTRICT')->onUpdate('RESTRICT');

            $table->unique(['recipe_id', 'position']);
        });

        // Ingredient_Recipe table
        Schema::create('ingredient_recipe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id')->constrained('recipe')->onDelete('CASCADE')->onUpdate('RESTRICT');
            // RESTRICT: receptben használt alapanyagot a MySQL nem enged törölni
            $table->foreignId('ingredient_id')->constrained('ingredient')->onDelete('RESTRICT')->onUpdate('RESTRICT');
            $table->double('quantity');
            $table->string('unit', 30);
        });

        // Favorite table
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->onDelete('CASCADE')->onUpdate('RESTRICT');
            $table->foreignId('recipe_id')->constrained('recipe')->onDelete('CASCADE')->onUpdate('RESTRICT');
            $table->timestamps();

            $table->unique(['user_id', 'recipe_id']);
        });

        // Rating table
        Schema::create('rating', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->onDelete('CASCADE')->onUpdate('RESTRICT');
            $table->foreignId('recipe_id')->constrained('recipe')->onDelete('CASCADE')->onUpdate('RESTRICT');
            $table->unsignedTinyInteger('score'); // 1-5

            $table->unique(['user_id', 'recipe_id']);
        });

        // Category tables (konstans adatok, a seeder tölti fel)
        foreach (['meal_time', 'food_type', 'diet', 'cuisine'] as $tableName) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->string('name', 50);
            });
        }

        // Mitől mentes a recept (pl. Glutén), áthúzott ikonnal
        Schema::create('free_from', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('thumbnail', 255);
        });

        // Pivot tables (recept <-> kategória, N:M kapcsolat)
        foreach (['meal_time', 'food_type', 'diet', 'cuisine', 'free_from'] as $category) {
            Schema::create($category . '_recipe', function (Blueprint $table) use ($category) {
                $table->foreignId($category . '_id')->constrained($category)->onDelete('CASCADE')->onUpdate('RESTRICT');
                $table->foreignId('recipe_id')->constrained('recipe')->onDelete('CASCADE')->onUpdate('RESTRICT');
                $table->primary([$category . '_id', 'recipe_id']);
            });
        }
    }

    public function down(): void
    {
        // Fordított sorrendben: előbb azok a táblák, amelyek másikra hivatkoznak
        foreach (['meal_time', 'food_type', 'diet', 'cuisine', 'free_from'] as $category) {
            Schema::dropIfExists($category . '_recipe');
            Schema::dropIfExists($category);
        }
        Schema::dropIfExists('rating');
        Schema::dropIfExists('favorites');
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
