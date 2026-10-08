<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Ezeknek a kategóriáknak nincs ikonja, ezért a thumbnail oszlop felesleges
    // (a free_from táblában marad, ott az áthúzott ikonokat tárolja)
    private array $tables = ['diet', 'food_type', 'meal_time', 'cuisine'];

    public function up(): void
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('thumbnail');
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('thumbnail', 255)->nullable();
            });
        }
    }
};
