<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    // tblinfosysexternalusers
	// infoExternal_id
	// infoExternal_externalId
	// infoExternal_infoSysId
    public function up(): void
    {
        Schema::create('tblinfosysexternalusers', function (Blueprint $table) {
            $table->id("infoExternal_id");

            $table->foreignId("infoExternal_externalId")
            ->constrained("tblexternalusers", "external_id")
            ->onDelete("cascade");

            $table->foreignId("infoExternal_infoSysId")
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
        Schema::dropIfExists('tblinfosysexternalusers');
    }
};
