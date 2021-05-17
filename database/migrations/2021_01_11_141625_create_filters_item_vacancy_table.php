<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiltersItemVacancyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filter_item_vacancy', function (Blueprint $table) {
            $table->unsignedBigInteger('vacancy_id');
            $table->unsignedBigInteger('filter_item_id');

            $table->index('filter_item_id');

            $table->foreign('vacancy_id')
                ->references('id')
                ->on('vacancies')
                ->onDelete('cascade');

            $table->foreign('filter_item_id')
                ->references('id')
                ->on('filter_items')
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
        Schema::dropIfExists('filters_item_vacancy');
    }
}
