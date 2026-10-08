<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // A kapcsolótábla és az oszlop átnevezése a free_from táblához igazodva.
        // Az adatok és az idegen kulcsok megmaradnak (a kulcsok/indexek neve - pl.
        // allergen_recipe_allergen_id_foreign - a régi marad, ez a működést nem érinti)
        Schema::rename('allergen_recipe', 'free_from_recipe');

        Schema::table('free_from_recipe', function (Blueprint $table) {
            $table->renameColumn('allergen_id', 'free_from_id');
        });
    }

    public function down(): void
    {
        Schema::table('free_from_recipe', function (Blueprint $table) {
            $table->renameColumn('free_from_id', 'allergen_id');
        });

        Schema::rename('free_from_recipe', 'allergen_recipe');
    }
};
