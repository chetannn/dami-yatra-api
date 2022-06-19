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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->date('ad_end_date')->nullable();
            $table->boolean('is_published')->default(0);
            $table->string('itinerary_file')->nullable();
            $table->foreignId('vendor_id')->constrained('vendors');
            $table->timestamps();
        });

        Schema::create('advertisements_tags', function (Blueprint $table) {
            $table->foreignId('advertisement_id')->index();
            $table->foreignId('tag_id')->index();

            $table->unique(['advertisement_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisements');
    }
};
