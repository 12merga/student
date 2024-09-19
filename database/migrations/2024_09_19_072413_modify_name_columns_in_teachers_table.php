<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyNameColumnsInTeachersTable extends Migration
{
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {
            // Remove the existing 'name' column
            $table->dropColumn('name');

            // Add new columns for first name, last name, and middle name
            $table->string('first_name');
            $table->string('middle_name')->nullable(); // Optional, allow null values
            $table->string('last_name');
        });
    }

    public function down()
    {
        Schema::table('teachers', function (Blueprint $table) {
            // Re-add the 'name' column if rolling back
            $table->string('name');

            // Drop the new columns
            $table->dropColumn(['first_name', 'middle_name', 'last_name']);
        });
    }
}
