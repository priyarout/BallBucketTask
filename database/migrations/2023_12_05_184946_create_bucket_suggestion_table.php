<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBucketSuggestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bucket_suggestion', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bucket_id');
            $table->unsignedInteger('ball_id');
            $table->integer('quantity');

            $table->foreign('bucket_id')->references('id')->on('buckets')->onDelete('cascade');
            $table->foreign('ball_id')->references('id')->on('balls')->onDelete('cascade');

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
        Schema::dropIfExists('bucket_suggestion');
    }
}
