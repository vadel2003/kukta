<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Csak két szerep van (admin / nem admin), ezért egy igen-nem (bool) mező elég.
        // Az "is_admin" név magáért beszél, nem kell fejben tartani, hogy az 1-es szám mit jelent.
        // 1. Átnevezés - az adatok megmaradnak (a 0 és 1 értékek pont a false / true-nak felelnek meg)
        Schema::table('user', function (Blueprint $table) {
            $table->renameColumn('role', 'is_admin');
        });

        // 2. Típusváltás boolean-re (MySQL/MariaDB-ben ez tinyint(1)), alapból false,
        // így új felhasználónál nem kell külön megadni
        Schema::table('user', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->integer('is_admin')->change();
        });

        Schema::table('user', function (Blueprint $table) {
            $table->renameColumn('is_admin', 'role');
        });
    }
};
