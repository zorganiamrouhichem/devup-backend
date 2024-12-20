<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('auberge', function (Blueprint $table) {
            $table->foreignId('id_user') // Ajout de la clé étrangère 'id_admin' vers 'users'
            ->constrained('users') // Fait référence à la table 'users'
            ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('auberge', function (Blueprint $table) {
            //
        });
    }
};
