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
        Schema::create('tblusers', function (Blueprint $table) {
            $table->id("user_id");
            $table->string("user_firstName");
            $table->string("user_middleName");
            $table->string("user_lastName");
            $table->string("user_email")->unique();
            $table->string("user_password");
            $table->date("user_birthdate");
            $table->foreignId("user_role")
                ->constrained("tblroles", "role_id")
                ->onDelete("cascade");
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblusers');
    }
};
