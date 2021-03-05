<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone_number');
            $table->string('location');
            $table->string('type');
            $table->string('package');
            $table->text('description')->nullable();
            $table->string('quantity')->nullable();
            $table->double('total_price');
            $table->double('paid_amount');
            $table->dateTime('shot_date');
            $table->dateTime('delivery_date');
            $table->string('status');
            $table->string('remark')->nullable();
            $table->integer('user_id');
            $table->json('service');
            $table->string('data_location')->nullable();
            $table->date('selection_date');
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
        Schema::dropIfExists('task');
    }
}
