<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            //Prima creiamo la colonna
            $table->unsignedBigInteger('type_id') //<--- Questo coincide con...
            ->nullable()
            ->after('id');

            //dopo creo la foreing key
            $table->foreign('type_id')//<--- ..questo
            ->references('id')// quale colonna fa riferimento
            ->on('types')// quale tabella fa riferimento
            ->onDelete('set null');//in caso cancellassimo il types lo setta null
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

            $table->dropForeign('posts_type_id_foreign');//droppa nella tabella posts type_id che è la foreing

            //2 passaggio
            //droppo la colonna
            $table->dropColumn('type_id');
        });
    }
};
