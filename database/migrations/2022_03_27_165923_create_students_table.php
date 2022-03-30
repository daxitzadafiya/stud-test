<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_id')->nullable()
                ->constrained()
                ->onDelete('set null');

            $table->foreignId('user_id')->nullable()
                ->constrained()
                ->onDelete('set null');

            $table->string('name');
            $table->integer('age');
            $table->string('email');
            $table->string('address');
            $table->date('dob');
            $table->string('gender');

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
        Schema::dropIfExists('students');
    }
};
