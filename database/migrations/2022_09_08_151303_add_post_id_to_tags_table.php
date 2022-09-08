<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPostIdToTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id')->nullable()->after('slug');
            // Creo la relazione con foreign key, tra post_id della tabella tags e id della tabella posts
            $table->foreign('post_id')
            ->references('id')
            ->on('posts')
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
        Schema::table('tags', function (Blueprint $table) {
            // Elimino la foreign key
            $table->dropForeign('tags_post_id_foreign');
            
            // Elimino la colonna tag_id
            $table->dropColumn('post_id');
        });
    }
}
