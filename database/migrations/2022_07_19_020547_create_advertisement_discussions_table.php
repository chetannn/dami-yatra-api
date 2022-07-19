<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisement_discussions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advertisement_id');
            $table->string('message');
            $table->string('sender_type');
            $table->foreignId('customer_id')->nullable();
            $table->foreignId('vendor_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisement_discussions');
    }
};
