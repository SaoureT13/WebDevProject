<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\User;
use \App\Models\Demande;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->string('theme');
            $table->string('memory_problems');
            $table->string('global_objective');
            $table->string('specific_objective');
            $table->string('expected_result');
            $table->timestamp('deposit_date');
            $table->boolean('request_status')->nullable();
            $table->timestamps();
        });

        Schema::create('demande_user', function (Blueprint $table) {
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Demande::class)->constrained()->cascadeOnDelete();
            $table->primary(['user_id', 'demande_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_user');
        Schema::dropIfExists('demandes');
    }
};
