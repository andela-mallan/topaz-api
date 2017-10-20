<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopazDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topazDetails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account_bank')->default('DFCU Bank');
            $table->string('account_name')->default('Lubega Denis Augustine & Naiga Vivianne Maria');
            $table->string('account_number')->default('01441014662455');
            $table->bigInteger('account_sum')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topazDetails');
    }
}
