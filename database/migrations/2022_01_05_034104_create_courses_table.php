<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'courses', function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'category_id' );
            $table->string( 'slug' );
            $table->string( 'title' );
            $table->string( 'image' );
            $table->enum( 'type', array('free', 'paid') );
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
        Schema::dropIfExists( 'courses' );
    }
}
