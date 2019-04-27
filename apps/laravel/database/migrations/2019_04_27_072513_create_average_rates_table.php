<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAverageRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('average_rates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique()->index('average_rate_code');
            $table->double('value')->default(0);
            $table->bigInteger('countRequests')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('average_rates');
    }
}
