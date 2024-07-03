<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_id')
                ->references('id')
                ->on('grades')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('year_id')
                ->references('id')
                ->on('years')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                $table->string('code', 10)->change();
            $table->string('name');
            $table->string('gender');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
