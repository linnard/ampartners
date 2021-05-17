<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilterItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filter_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('filter_id');
            $table->string('name');
            $table->string('slug');
            $table->integer('position');
            $table->boolean('selected_default')->default(false);
            $table->timestamps();

            $table->foreign('filter_id')
                ->references('id')
                ->on('filters')
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
        Schema::dropIfExists('filter_items');
    }
}
