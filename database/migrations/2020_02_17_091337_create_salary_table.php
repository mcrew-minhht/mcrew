<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('base_salary');
            $table->bigInteger('salary');
            $table->bigInteger('number_of_dependents');
            $table->timestamps();
            $table->bigInteger('created_user');
            $table->bigInteger('updated_user');
            $table->primary(['id', 'user_id']);
            // $table->primary('user_id');
        });

        Schema::table('salary', function (Blueprint $table) {
            $table->bigInteger('id', true, true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary');
    }
}
