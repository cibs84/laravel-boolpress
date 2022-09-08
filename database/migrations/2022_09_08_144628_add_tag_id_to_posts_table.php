<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTagIdToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('tag_id')->nullable()->after('category_id');
            // Creo la relazione con foreign key, tra tag_id della tabella posts e id della tabella tags
            $table->foreign('tag_id')
            ->references('id')
            ->on('tags')
            // se la tabella tags viene eliminata, verrà settato null di default per evitare errori
            ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Elimino la colonna tag_id
            $table->dropColumn('tag_id');
        });
    }
}
