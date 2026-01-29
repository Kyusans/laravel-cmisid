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
        Schema::create('tblworkingenvironments', function (Blueprint $table) {
            $table->id("workEnv_id");
            $table->string("workEnv_name")->unique();
            $table->text("workEnv_description");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblworkingenvironments');
    }
};
