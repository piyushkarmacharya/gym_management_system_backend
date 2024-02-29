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
        Schema::create('member', function (Blueprint $table) {
            $table->id('mid');
            $table->string('name');
            $table->dateTime('dob');
            $table->enum('gender',["M","F","O"]);
            $table->string('email');
            $table->bigInteger('contact_number');
            $table->string('address');
            $table->double('weight');
            $table->double('height');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member');
    }
};
