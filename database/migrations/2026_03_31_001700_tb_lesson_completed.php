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
        Schema::create('tb_lesson_progress', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('fk_id_class');

        $table->foreignId('fk_id_student')->constrained('users')->cascadeOnDelete();
        $table->foreign('fk_id_class')
                ->references('id_class')->on('tb_class')->cascadeOnDelete();

        $table->boolean('is_completed')->default(false);

        $table->timestamp('completed_at')->nullable();

        $table->timestamps();

        $table->unique(['fk_id_student', 'fk_id_class']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
