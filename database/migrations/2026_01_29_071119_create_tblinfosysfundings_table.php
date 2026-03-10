<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    // tblinfosysfundings
    // infoFund_id
    // infoFund_fundingId
    // infoFund_infoSysId

    public function up(): void
    {
        Schema::create('tblinfosysfundings', function (Blueprint $table) {
            $table->id("infoFund_id");
            
            $table->foreignId("infoFund_fundingId")
                ->constrained("tblfundingsource", "funding_id")
                ->restrictOnDelete();

            $table->foreignId("infoFund_infoSysId")
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
        Schema::dropIfExists('tblinfosysfundings');
    }
};
