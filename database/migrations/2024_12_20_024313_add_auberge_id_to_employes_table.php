<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAubergeIdToEmployesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employes', function (Blueprint $table) {
            // Ajouter la colonne 'auberge_id' à la table 'employes'
            $table->foreignId('auberge_id')->nullable()
                ->constrained('auberge') // Crée une contrainte sur la table 'auberges'
                ->onDelete('set null'); // Si l'auberge est supprimée, set null sur 'auberge_id'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employes', function (Blueprint $table) {
            // Supprimer la contrainte de clé étrangère et la colonne 'auberge_id'
            $table->dropForeign(['auberge_id']);
            $table->dropColumn('auberge_id');
        });
    }
}
