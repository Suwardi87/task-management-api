<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrentTeamsTable extends Migration
{
    public function up(): void
    {
        Schema::create('current_teams', function (Blueprint $table) {
            $table->id(); // Atau gunakan $table->uuid('id')->primary(); jika perlu
            $table->string('name'); // Contoh kolom lain
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('current_teams');
    }
}