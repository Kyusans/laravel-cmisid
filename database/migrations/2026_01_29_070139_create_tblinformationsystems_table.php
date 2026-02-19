<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * 
     */
    public function up(): void
    {
        Schema::create('tblinformationsystems', function (Blueprint $table) {
            $table->id("infoSys_id");
            $table->integer("infoSys_rank");
            $table->boolean("infoSys_isSmartCityInitiative")->default(false);
            $table->string("infoSys_systemName")->unique();
            $table->text("infoSys_description");

            $table->foreignId("infoSys_systemTypeId")
                ->constrained("tblsystemtypes", "systemType_id")
                ->onDelete("cascade");

            $table->foreignId("infoSys_officeId")
                ->constrained("tbloffices", "office_id")
                ->onDelete("cascade");

            $table->foreignId("infoSys_systemStatusId")
                ->constrained("tblsystemstatus", "sysStatus_id")
                ->onDelete("cascade");

            $table->foreignId("infoSys_workEnvId")
                ->constrained("tblworkingenvironments", "workEnv_id")
                ->onDelete("cascade");

            $table->foreignId("infoSys_devStrategyId")
                ->constrained("tbldevelopmentstrategies", "devStrategy_id")
                ->onDelete("cascade");

            $table->boolean("infoSys_hasPIA")->default(false);
            $table->date("infoSys_datePia")->nullable();
            $table->year("infoSys_initiationYear")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblinformationsystems');
    }
};
