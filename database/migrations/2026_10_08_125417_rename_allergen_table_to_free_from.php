<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // A tábla átnevezése: az adatok és az allergen_recipe tábla idegen kulcsa is megmarad
        // (a MySQL a kulcsot automatikusan az új táblanévre állítja), csak a tábla neve változik
        Schema::rename('allergen', 'free_from');
    }

    public function down(): void
    {
        Schema::rename('free_from', 'allergen');
    }
};
