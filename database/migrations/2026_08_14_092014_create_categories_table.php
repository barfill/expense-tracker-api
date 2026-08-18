<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expense_tracker.categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->nullable()->constrained('expense_tracker.users');
            $table->string('code', 50);
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->enum('type', ['expense', 'income'])->default('expense');
            $table->boolean('is_public')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['created_by', 'code']);
        });

        DB::statement('CREATE UNIQUE INDEX categories_system_code_unique ON expense_tracker.categories (code) WHERE created_by IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_tracker.categories');
        DB::statement('DROP INDEX IF EXISTS categories_system_code_unique');
    }
};
