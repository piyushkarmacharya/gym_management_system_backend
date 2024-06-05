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
            $table->date('dob')->nullable();
            $table->enum('gender',["M","F","O"]);
            $table->string('email')->unique();
            $table->bigInteger('contact_number');
            $table->string('address');
            $table->double('weight')->nullable();
            $table->double('height')->nullable();
            $table->mediumText('photo');
            $table->string('password');
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
