<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_rule', function (Blueprint $table) {
            $table->increments('tax_rule_id');
            $table->integer('amount');
            $table->integer('percentage_of_tax');
            $table->integer('amount_of_tax');
            $table->string('gender',20);
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
        Schema::dropIfExists('tax_rule');
    }
}
