<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invites', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id_sent')->unsigned()->index();
            $table->bigInteger('user_id_receive')->unsigned()->index();
            $table->enum('status', ['Pending','Approved','Declined']);
            $table->timestamps();

            $table->foreign('user_id_sent')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('user_id_receive')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invites');
    }
}
