<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActivityIdToEtablissementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('etablissements', function (Blueprint $table) {
            $table->foreignId('activity_id')->nullable() // La clé étrangère vers la table 'activities', qui peut être nulle
                  ->constrained('activities') // Fait référence à la table 'activities'
                  ->onDelete('set null'); // Si l'activité est supprimée, mettre 'activity_id' à null
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('etablissements', function (Blueprint $table) {
            $table->dropForeign(['activity_id']); // Supprimer la contrainte de clé étrangère
            $table->dropColumn('activity_id'); // Supprimer la colonne 'activity_id'
        });
    }
}
