<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Drinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('drinks', function (Blueprint $table) {
			$table->bigIncrements('id');
            $table->string('vunetid');
            $table->string('type');
            $table->integer('amount');
			$table->double('cost');
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
