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
        Schema::create('video_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_type')->nullable();
            $table->string('watch_party_code')->nullable();
            $table->string('instance_name')->nullable();
            $table->decimal('current_time', 10, 3)->nullable();
            $table->decimal('current_volume')->nullable();
            $table->decimal('seek_value', 10, 3)->nullable();
            $table->decimal('duration', 10, 3)->nullable();
            $table->integer('counter')->nullable();
            $table->json('media_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_events');
    }
};
