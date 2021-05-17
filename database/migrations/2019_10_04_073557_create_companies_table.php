<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('creator_id');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('viber')->nullable();
            $table->string('email')->nullable();
            $table->string('site')->nullable();
            $table->text('license_url')->nullable();
            $table->text('facebook_url')->nullable();
            $table->text('instagram_url')->nullable();
            $table->text('other_url')->nullable();
            $table->text('additional_info')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
