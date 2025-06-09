<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    protected $table = 'ingredient_product_type';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                $table->string('product_type_id');
                $table->foreign('product_type_id')
                      ->references('product_type_id')
                      ->on('product_types')
                      ->onDelete('cascade');
            
                $table->foreignId('ingredient_id')
                      ->constrained('ingredients')
                      ->onDelete('cascade');
            
                $table->timestamps();
            
                $table->unique(['product_type_id', 'ingredient_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable($this->table)) {
            Schema::dropIfExists($this->table);
        }
    }
};
