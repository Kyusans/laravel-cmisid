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
    //     tblinformationsystems
    // - infoSys_id
    // - infoSys_rank (priority)
    // - infoSys_isSmartCityInitiative (BOOLEAN)
    // - infoSys_systemName (VARCHAR)
    // - infoSys_description (TEXT)
    // - infoSys_riseAgendaId (FK)
    // - infoSys_connectToRiseAgenda (TEXT)
    // - infoSys_systemTypeId (FK)
    // - infoSys_officeId (FK)
    // - infoSys_systemStatusId (FK)
    // - infoSys_workEnvId (FK)
    // - infoSys_internalUsers (TEXT)
    // - infoSys_externalUsers (TEXT)
    // - infoSys_MFO (TEXT)
    // - infoSys_PPA (TEXT)
    // - infoSys_connectWithMFO (TEXT)
    // - infoSys_fundingSource (TEXT)
    // - infoSys_hasPIA (BOOLEAN)
    // - infoSys_datePia (DATE)
    // - infoSys_initationYear (DATE)
    public function up(): void
    {
        Schema::create('tblinformationsystems', function (Blueprint $table) {
            $table->id("infoSys_id");
            $table->integer("infoSys_rank");
            $table->boolean("infoSys_isSmartCityInitiative")->default(false);
            $table->string("infoSys_systemName")->unique();
            $table->text("infoSys_description");
            $table->foreignId("infoSys_riseAgendaId")
                ->constrained("tblriseagendas", "riseAgenda_id")
                ->onDelete("cascade");
            $table->text("infoSys_connectToRiseAgenda")->nullable();
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
            $table->text("infoSys_internalUsers");
            $table->text("infoSys_externalUsers");
            $table->text("infoSys_MFO");
            $table->text("infoSys_PPA");
            $table->text("infoSys_connectWithMFO")->nullable();
            $table->text("infoSys_fundingSource")->nullable();
            $table->boolean("infoSys_hasPIA")->default(false);
            $table->date("infoSys_datePia")->nullable();
            $table->year("infoSys_initationYear")->nullable();

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
