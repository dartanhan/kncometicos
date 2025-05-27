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
        Schema::create('tbl_loja_produtos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome', 255);
            $table->string('descricao', 255);
            $table->string('codigo_barras', 255);
            $table->string('sku', 155)->nullable()->comment("código do produto");
            $table->decimal('preco', 10, 2)->default(0.00);
            $table->integer('estoque')->default(0);
            $table->integer('quantidade')->default(0);
            $table->boolean('tem_variacao')->default(false);
            $table->boolean("status")->default(false)->comment("produto ativo ou inativo");

            $table->foreignId('subcategoria_id')->nullable()->constrained('tbl_loja_subcategorias');

            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_loja_produtos');
    }
};
