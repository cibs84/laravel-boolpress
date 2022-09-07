<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Creo la nuova colonna category_id dopo la slug già presente
            // e la rendo nullable in quanto i post possono non avere una categoria
            $table->unsignedBigInteger('category_id')->nullable()->after('slug');

            // Creo la relazione con foreign key tra category_key della tabella posts e id della tabella categories
            $table->foreign('category_id')
            ->references('id')
            ->on('categories')
            // se la categoria viene eliminata nella tabella categories o viene eliminata la tabella stessa, 
            // verrà settato null di default per evitare errori
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
            // Elimino la foreign key
            $table->dropForeign('posts_category_id_foreign');

            // Elimino la colonna
            $table->dropColumn('category_id');
        });
    }
}
