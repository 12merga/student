<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('first_name'); // Parent's first name
            $table->string('middle_name')->nullable(); // Parent's middle name
            $table->string('last_name'); // Parent's last name
            $table->string('student_first_name'); // Student's first name
            $table->string('student_middle_name')->nullable(); // Student's middle name
            $table->string('student_last_name'); // Student's last name
            $table->string('student_id'); // Reference to the student's ID (can be foreign key if needed)
            $table->string('phone_number'); // Parent's phone number
            $table->string('email')->unique(); // Parent's email
            $table->string('password'); // Hashed password
            $table->boolean('approved')->default(false); // Admin approval status
            $table->timestamps(); // Created at and updated at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parents');
    }
}
