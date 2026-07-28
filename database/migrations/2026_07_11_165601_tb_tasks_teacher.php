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
        //
        Schema::create('tb_tasks_teacher', function (Blueprint $table) {
            $table->id('id_task');
            $table->foreignId('fk_id_teacher')->constrained('tb_teacher')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title_task');
            $table->uuid('public_id')->unique()->default(DB::raw('gen_random_uuid()'));
            $table->text('description_task');
            $table->date('deadline_task')->nullable();
            $table->integer('time_task')->nullable();
            $table->enum('type_task', ['task', 'notification'])->default('task');
            $table->boolean('completed_task')->default(false);
            $table->dateTime('send_date')->useCurrent();
            $table->timestamps();
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
