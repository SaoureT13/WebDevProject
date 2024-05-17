<?php

use App\Models\Commentaire;
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
        Schema::create('commentaires', function (Blueprint $table) {
            $table->id();
            $table->string('comment_theme');
            $table->string('comment_problems');
            $table->string('comment_global_obj');
            $table->string('comment_specific_obj');
            $table->string('comment_result_expected');
            $table->string('other_comments')->nullable();
            $table->timestamps();
        });

        Schema::table('demandes', function (Blueprint $table) {
            $table->foreignIdFor(Commentaire::class)->nullable()->unique()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demandes', function (Blueprint $table) {
            $table->dropForeignIdFor(Commentaire::class);
        });
        Schema::dropIfExists('commentaires');
    }
};
