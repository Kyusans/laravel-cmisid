<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    // tblinfosysriseagenda
	// infoAgenda_id
	// infoAgenda_riseAgendaId
	// infoAgenda_infoSysId
	// infoAgenda_connectToRiseAgenda
    public function up(): void
    {
        Schema::create('tblinfosysriseagenda', function (Blueprint $table) {
            $table->id("infoAgenda_id");

            $table->foreignId("infoAgenda_riseAgendaId")
            ->constrained("tblriseagendas", "riseAgenda_id")
            ->onDelete("cascade");

            $table->foreignId("infoAgenda_infoSysId")
            ->constrained("tblinformationsystems", "infoSys_id")
            ->onDelete("cascade");
            
            // $table->text("infoAgenda_connectToRiseAgenda");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblinfosysriseagenda');
    }
};
