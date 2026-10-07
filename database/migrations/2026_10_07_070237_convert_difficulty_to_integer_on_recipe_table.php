<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // A nehézség szöveg helyett szám lesz (mint a user.role): 0 = könnyű, 1 = közepes, 2 = nehéz.
        // A szám -> megnevezés párosítás a Recipe::DIFFICULTIES konstansban van.
        // 1. A meglévő szövegeket számra cseréljük (még a szöveges oszlopban, '0'/'1'/'2' formában)
        DB::table('recipe')->where('difficulty', 'könnyű')->update(['difficulty' => '0']);
        DB::table('recipe')->where('difficulty', 'közepes')->update(['difficulty' => '1']);
        DB::table('recipe')->where('difficulty', 'nehéz')->update(['difficulty' => '2']);

        // 2. Az oszlop típusát számra váltjuk - a '0'/'1'/'2' szövegeket a MariaDB számmá alakítja
        Schema::table('recipe', function (Blueprint $table) {
            $table->unsignedTinyInteger('difficulty')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('recipe', function (Blueprint $table) {
            $table->string('difficulty', 20)->nullable()->change();
        });

        DB::table('recipe')->where('difficulty', '0')->update(['difficulty' => 'könnyű']);
        DB::table('recipe')->where('difficulty', '1')->update(['difficulty' => 'közepes']);
        DB::table('recipe')->where('difficulty', '2')->update(['difficulty' => 'nehéz']);
    }
};
