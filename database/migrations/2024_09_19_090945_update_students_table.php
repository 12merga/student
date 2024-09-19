<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStudentsTable extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            // Drop existing student_id column
            if (Schema::hasColumn('students', 'student_id')) {
                $table->dropColumn('student_id');
            }
            if (Schema::hasColumn('students', 'first_name')) {
                $table->dropColumn('first_name');
            }
            if (Schema::hasColumn('students', 'last_name')) {
                $table->dropColumn('last_name');
            }
            if (Schema::hasColumn('students', 'middle_name')) {
                $table->dropColumn('middle_name');
            }
            if (Schema::hasColumn('students', 'date_of_birth')) {
                $table->dropColumn('date_of_birth');
            }
            if (Schema::hasColumn('students', 'age')) {
                $table->dropColumn('age');
            }
            if (Schema::hasColumn('students', 'email')) {
                $table->dropColumn('email');
            }
            if (Schema::hasColumn('students', 'class')) {
                $table->dropColumn('class');
            }

            // Add the student_id column again
            $table->string('student_id')->unique()->after('id');

            // Reorder other columns as necessary
            $table->string('first_name')->after('student_id');
            $table->string('last_name')->after('first_name');
            $table->string('middle_name')->nullable()->after('last_name');
            $table->date('date_of_birth')->after('middle_name');
            $table->integer('age')->nullable()->after('date_of_birth');
            $table->string('email')->unique()->after('age');
            $table->string('class')->after('email');
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['student_id', 'first_name', 'last_name', 'middle_name', 'date_of_birth', 'age', 'email', 'class']);
        });
    }
}
