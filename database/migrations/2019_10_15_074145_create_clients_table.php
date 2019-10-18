<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('company_id');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->unsignedBigInteger('vacancy_id')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('ticket_uploaded')->default(0);
            $table->enum('status',
                array_values((new ReflectionClass(\App\Models\Client\Constants\Status::class))->getConstants())
            )->default(\App\Models\Client\Constants\Status::CREATING);

            $table->timestamp('complete_at')->nullable();
            $table->timestamps();

            $table->foreign('vacancy_id')->references('id')->on('vacancies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
