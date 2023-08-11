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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_id')
            ->constrained('deliveries')
            ->onUpdate('cascade')->onDelete('restrict');
            $table->integer('folio');
            $table->string('name');
            $table->string('paternal');
            $table->string('maternal');
            $table->string('municipality');
            $table->decimal('amount', $precision = 8, $scale = 2);
            $table->integer('check_id');
            $table->json('options');
            $table->timestamps();
            $table->foreignId('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
