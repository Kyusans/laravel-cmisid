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
        Schema::create('tblsystemproblems', function (Blueprint $table) {
            $table->id("sysprob_id");
            $table->foreignId("sysprob_infoSysId")
                ->constrained("tblinformationsystems", "infoSys_id")
                ->restrictOnDelete();
            $table->text("sysprob_problem");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblsystemproblems');
    }
};
