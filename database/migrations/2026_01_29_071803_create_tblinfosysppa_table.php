<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */


    // tblinfosysppa
    // 	infoPpa_id
    // 	infoPpa_ppaId
    // 	infoPpa_infoSysId
    public function up(): void
    {
        Schema::create('tblinfosysppa', function (Blueprint $table) {
            $table->id("infoPpa_id");

            $table->foreignId("infoPpa_ppaId")
            ->constrained("tblppa", "ppa_id")
            ->onDelete("cascade");

            $table->foreignId("infoPpa_infoSysId")
            ->constrained("tblinformationsystems", "infoSys_id")
            ->onDelete("cascade");
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblinfosysppa');
    }
};
