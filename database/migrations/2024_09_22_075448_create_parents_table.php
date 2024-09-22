<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentsTable extends Migration
{
    public function up()
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('student_first_name');
            $table->string('student_last_name');
            $table->string('student_middle_name')->nullable();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('phone_number');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_approved')->default(false); // Approval status
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('parents');
    }
}
