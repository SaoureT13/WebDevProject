<?php

use App\Models\Professeur;
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
        Schema::create('professeurs', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('course');
            $table->string('contact');
            $table->timestamp('last_student_assigned_at')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignIdFor(Professeur::class)->nullable()->constrained()->nullOnDelete();
        });

        /*Pour mettre à jour
            $professeur->élèves()->attach($élèveId);
            $professeur->update(['last_student_assigned_at' => now()]);
         */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeignIdFor(Professeur::class);
        });
        Schema::dropIfExists('professeurs');
    }
};
