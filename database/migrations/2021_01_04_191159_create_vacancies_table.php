<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('title');
            $table->json('content');
            $table->text('changes')->nullable();
            $table->unsignedInteger('age_from')->nullable();
            $table->unsignedInteger('age_to')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_urgently')->default(false);
            $table->boolean('is_individual_coordination')->default(false);
            $table->unsignedTinyInteger('status')->default(App\Constants\Vacancy\Status::Visible);

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
        Schema::dropIfExists('vacancies');
    }
}
