<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    // tblinfosysmfo
	// infoMfo_id
	// infoMfo_mfoId
	// infoMfo_infoSysId
	// infoMfo_connectWithMFO
    public function up(): void
    {
        Schema::create('tblinfosysmfo', function (Blueprint $table) {
            $table->id("infoMfo_id");

            $table->foreignId("infoMfo_mfoId")
            ->constrained("tblmfo", "mfo_id")
            ->onDelete("cascade");

            $table->foreignId("infoMfo_infoSysId")
            ->constrained("tblinformationsystems", "infoSys_id")
            ->onDelete("cascade");
            
            $table->text("infoMfo_connectWithMFO");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblinfosysmfo');
    }
};
