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
        Schema::create('tb_support', function (Blueprint $table) {
            $table->id('id_support');


            $table->foreignId('fk_id_sender_user')->constrained('users')->cascadeOnDelete();
            $table->uuid('public_id')->unique()->default(DB::raw('gen_random_uuid()'));
            $table->string('title_support', 255);
            $table->text('message_support');
            $table->enum('type_support', ['falha_plataforma', 'sugestao_melhoria' ]);

            $table->boolean('status_support')->default(false);

            $table->dateTime('issued_at')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('tb_support');
    }
};
