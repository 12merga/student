<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTeachersTableReorderColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {
            // Reorder the columns
            $table->string('first_name')->after('id')->change();
            $table->string('last_name')->after('first_name')->change();
            $table->string('middle_name')->nullable()->after('last_name')->change();
            $table->string('title')->after('middle_name')->change();
            $table->string('phone_number')->after('title')->change();
            $table->string('email')->after('phone_number')->change();
            $table->string('subject')->after('email')->change();
            $table->string('password')->after('subject')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // You can reverse the order of columns if necessary, but it's usually not required.
        // Laravel does not natively support "reverting" column reorders.
    }
}
