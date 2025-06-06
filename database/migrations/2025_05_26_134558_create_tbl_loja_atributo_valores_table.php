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
        Schema::create('tbl_loja_atributo_valores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tbl_loja_atributo_valores_id')->constrained()->onDelete('cascade');
            $table->string('valor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_loja_atributo_valores');
    }
};
