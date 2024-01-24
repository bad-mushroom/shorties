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
        Schema::create('urls', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('long_url');
            $table->string('short_code')->unique()->index();
            $table->timestamps();

            /**
             * For future consideration, associate the URL with a user. That
             * will allow us to offer a more customized experience in the
             * UI and prevent the same user from creating duplicated
             * URLs.
             *
             * $table->foreignUuid('user_id')
             *    ->constrained()
             *    ->onDelete('cascade');
             *
             * $table->unique(['user_id', 'long_url'])
             */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urls');
    }
};
