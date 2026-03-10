<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    // tblinfosysdevelopers
    // infodev_id
    // infodev_devId
    // infodev_infoSysId
    public function up(): void
    {
        Schema::create('tblinfosysdevelopers', function (Blueprint $table) {
            $table->id("infoDev_id");

            $table->foreignId("infoDev_devId")
                ->constrained("tbldevelopers", "dev_id")
                ->restrictOnDelete();

            $table->foreignId("infoDev_infoSysId")
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
        Schema::dropIfExists('tblinfosysdevelopers');
    }
};
