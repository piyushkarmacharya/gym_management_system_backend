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
        Schema::create('staff', function (Blueprint $table) {
            $table->id("sid");
            $table->String("first name");
            $table->String("last name");
            $table->Enum("gender",["M","F","O"]);
            $table->String("phone number");
            $table->String("address");
            $table->String("email")->unique();
            $table->String("password");


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
