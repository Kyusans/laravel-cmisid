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
        Schema::create('tblppa', function (Blueprint $table) {
            $table->id("ppa_id");
            $table->string("ppa_name")->unique();
            $table->foreignId("ppa_officeId")
                ->constrained("tbloffices", "office_id")
                ->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblppa');
    }
};
