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
        Schema::create('tblriseagendas', function (Blueprint $table) {
            $table->id("riseAgenda_id");
            $table->string("riseAgenda_name")->unique();
            $table->text("riseAgenda_description");
            $table->foreignId("riseAgenda_agendaTypeId")
                ->constrained("tblriseagendatypes", "agendaType_id")
                ->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblriseagendas');
    }
};
