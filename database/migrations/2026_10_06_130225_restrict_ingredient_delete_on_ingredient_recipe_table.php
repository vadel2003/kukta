<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Receptben használt alapanyag ne legyen törölhető: CASCADE helyett RESTRICT.
        // CASCADE-del az alapanyag törlése csendben eltüntette azt minden receptből,
        // RESTRICT-tel maga a MySQL tagadja meg a törlést, ha van rá hivatkozás.
        // Egy idegen kulcs szabályát nem lehet módosítani, ezért töröljük és újra létrehozzuk.
        Schema::table('ingredient_recipe', function (Blueprint $table) {
            $table->dropForeign(['ingredient_id']);
            $table->foreign('ingredient_id')->references('id')->on('ingredient')->onDelete('RESTRICT')->onUpdate('RESTRICT');
        });
    }

    public function down(): void
    {
        Schema::table('ingredient_recipe', function (Blueprint $table) {
            $table->dropForeign(['ingredient_id']);
            $table->foreign('ingredient_id')->references('id')->on('ingredient')->onDelete('CASCADE')->onUpdate('RESTRICT');
        });
    }
};
