<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Deposits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
			$table->bigIncrements('id');
            $table->string('vunetid');
            $table->double('deposit');
			$table->string('status');
			$table->date('date');
			$table->date('time');
			$table->foreign('vunetid')->references('vunetid')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
