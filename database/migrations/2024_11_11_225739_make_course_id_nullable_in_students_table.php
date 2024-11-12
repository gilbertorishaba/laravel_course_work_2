<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeCourseIdNullableInStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Disable foreign key constraints to avoid issues during the alteration
        Schema::disableForeignKeyConstraints();

        Schema::table('students', function (Blueprint $table) {
            // Make the 'course_id' column nullable
            $table->unsignedBigInteger('course_id')->nullable()->change();
        });

        // Enable foreign key constraints again after making the changes
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Disable foreign key constraints to avoid issues during rollback
        Schema::disableForeignKeyConstraints();

        Schema::table('students', function (Blueprint $table) {
            // Reverse the change, making 'course_id' not nullable again
            $table->unsignedBigInteger('course_id')->nullable(false)->change();
        });

        // Enable foreign key constraints again after reverting the changes
        Schema::enableForeignKeyConstraints();
    }
}
