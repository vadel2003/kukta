<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // A slug a kategória "gépi neve": ékezet nélküli, URL-barát, és egyezik a
        // public/lottie/{slug}.json animáció fájlnevével
        Schema::table('step_category', function (Blueprint $table) {
            $table->string('slug', 50)->nullable()->unique()->after('name');
        });

        // A már meglévő sorok kitöltése név alapján (friss telepítésnél a seeder tölti ki)
        $slugs = [
            'Előkészítés' => 'elokeszites',
            'Elkészítés' => 'elkeszites',
            'Főzés' => 'fozes',
            'Sütés' => 'sutes',
            'Tálalás' => 'talalas',
        ];

        foreach ($slugs as $name => $slug) {
            DB::table('step_category')->where('name', $name)->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        Schema::table('step_category', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
