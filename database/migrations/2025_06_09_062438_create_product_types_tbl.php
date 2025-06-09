<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $table = 'product_types';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable($this->table)) {
            Schema::create('product_types', function (Blueprint $table) {
                $table->string('product_type_id')->nullable()->default(null)->primary();
                $table->text('name')->nullable()->default(null);
                $table->integer('category_id')->unsigned()->nullable()->default(0);
                $table->softDeletes();
                $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->integer('created_by')->unsigned()->nullable()->default(0);
                $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
                $table->integer('updated_by')->unsigned()->nullable()->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable($this->table)) {
            Schema::dropIfExists('product_types');
        }
    }
};
