<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentEnrollsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'student_enrolls', function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'member_id' );
            $table->unsignedBigInteger( 'user_id' );
            $table->string( 'payment_image' );
            $table->enum( 'type', array( 'active', 'expire', 'pending' ) )->default( 'pending' );
            $table->string( 'learn_date' );
            $table->string( 'start_date' )->nullable();
            $table->string( 'expire_date' )->nullable();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'student_enrolls' );
    }
}
