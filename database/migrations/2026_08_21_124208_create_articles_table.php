<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Ce qu'on fait quand on "applique" la migration
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('contenu');
            $table->timestamps();
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->string('auteur')->nullable();
        });
    }

    // Ce qu'on fait pour "annuler" la migration
    public function down(): void
    {
        Schema::dropIfExists('articles');

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('auteur');
        });
    }
};
