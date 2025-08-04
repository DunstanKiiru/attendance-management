<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('attendances', function (Blueprint $table) {
        $table->id();
        $table->foreignId('employee_id')->constrained()->onDelete('cascade');
        $table->date('date');
        $table->time('clock_in')->nullable();
        $table->time('clock_out')->nullable();
        $table->string('method')->default('rfid');
        $table->boolean('verified')->default(false);
        $table->string('status')->default('Absent'); // Present, Late, Absent
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
