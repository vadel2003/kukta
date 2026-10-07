<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Az "order" SQL-ben foglalt szó (ORDER BY), ezért nyers SQL-ben mindig idézőjelezni
        // kellene - a "position" ugyanazt jelenti (a lépés sorszáma a recepten belül), de
        // nem ütközik semmivel. Az oszlop adatai megmaradnak, csak a neve változik.
        if (Schema::hasColumn('step', 'order')) {
            Schema::table('step', function (Blueprint $table) {
                $table->renameColumn('order', 'position');
            });
        }

        // Az egyedi index nevében is benne van az oszlop neve. Az XAMPP MariaDB-je nem tud
        // indexet átnevezni (RENAME INDEX), ezért újat veszünk fel és a régit töröljük.
        // Sorrend: előbb az új, mert a recipe_id idegen kulcsnak mindig kell egy index.
        Schema::table('step', function (Blueprint $table) {
            $table->unique(['recipe_id', 'position']);
        });
        Schema::table('step', function (Blueprint $table) {
            $table->dropUnique('step_recipe_id_order_unique');
        });
    }

    public function down(): void
    {
        Schema::table('step', function (Blueprint $table) {
            $table->renameColumn('position', 'order');
        });
        Schema::table('step', function (Blueprint $table) {
            $table->unique(['recipe_id', 'order']);
        });
        Schema::table('step', function (Blueprint $table) {
            $table->dropUnique('step_recipe_id_position_unique');
        });
    }
};
