<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    // tblinfosysinternalusers
    // infoInternal_id
    // infoInternal_internalId
    // infoInternal_infoSysId
    public function up(): void
    {
        Schema::create('tblinfosysinternalusers', function (Blueprint $table) {
            $table->id("infoInternal_id");

            $table->foreignId("infoInternal_officeId")
                ->constrained("tbloffices", "office_id")
                ->restrictOnDelete();

            $table->foreignId("infoInternal_infoSysId")
                ->constrained("tblinformationsystems", "infoSys_id")
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblinfosysinternalusers');
    }
};
