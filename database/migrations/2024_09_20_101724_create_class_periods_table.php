<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('class_periods', function (Blueprint $table) {
            $table->id();
            $table->string('class'); // Class name or ID reference
            $table->string('monday')->nullable(); // Period or subject for Monday
            $table->string('tuesday')->nullable(); // Period or subject for Tuesday
            $table->string('wednesday')->nullable(); // Period or subject for Wednesday
            $table->string('thursday')->nullable(); // Period or subject for Thursday
            $table->string('friday')->nullable(); // Period or subject for Friday
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_periods');
    }
};
