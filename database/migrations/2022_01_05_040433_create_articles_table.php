<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'articles', function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'category_id' );
            $table->string( 'slug' );
            $table->string( 'title' );
            $table->string( 'image' );
            $table->integer( 'like_count' );
            $table->longText( 'description' );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'articles' );
    }
}
