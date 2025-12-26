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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->dateTime('transport_datetime');
            $table->decimal('weight', 10, 2)->comment('Вес груза');
            $table->string('dimensions')->comment('Габариты груза');
            $table->string('from_address');
            $table->string('to_address');
            $table->string('cargo_type');
            $table->enum('status', ['Новая', 'В работе', 'Отменена'])->default('Новая');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
