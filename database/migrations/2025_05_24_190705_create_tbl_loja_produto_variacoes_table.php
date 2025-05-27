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
        Schema::create('tbl_loja_produto_variacoes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('produto_id');
            $table->string('nome', 255);
            $table->string('sku', 155)->nullable()->comment("código do produto");;
            $table->decimal('preco', 10, 2)->default(0.00);
            $table->integer('estoque')->default(0);
            $table->integer('quantidade')->default(0);
            $table->boolean("status")->default(false)->comment("variação ativa ou inativa");
            $table->json('atributos');
            $table->timestamps();

            $table->foreign('produto_id')
                ->references('id')
                ->on('tbl_loja_produtos')
                ->onUpdate('no action')
                ->onDelete('no action');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->index(['produto_id'], 'tbl_loja_produto_variacoes_produto_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_loja_produto_variacoes');
    }
};
