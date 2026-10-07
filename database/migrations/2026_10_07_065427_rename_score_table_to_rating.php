<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // A tábla átnevezése: az adatok, az idegen kulcsok és az indexek is megmaradnak,
        // csak a tábla neve változik (az indexek neve - pl. score_user_id_foreign - marad a régi)
        Schema::rename('score', 'rating');
    }

    public function down(): void
    {
        Schema::rename('rating', 'score');
    }
};
