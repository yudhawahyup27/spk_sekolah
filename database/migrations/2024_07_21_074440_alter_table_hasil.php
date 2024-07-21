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
        Schema::table('hasil', function (Blueprint $table) {
            $table->unsignedBigInteger('semester')->after('score');
            $table->foreign('semester')->references('id')->on('semester')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil', function (Blueprint $table) {
            $table->dropForeign(['semester']);
            $table->dropColumn('semester');
        });
    }

};
