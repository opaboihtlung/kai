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
        Schema::table('attendances', function (Blueprint $table) {
            $table->index('id'); // Index for faster lookups
            $table->index('signout_at');
            $table->index('signout_lat');
            $table->index('signout_lng');
            $table->index('out_remark');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex(['id']);
            $table->dropIndex(['signout_at']);
            $table->dropIndex(['signout_lat']);
            $table->dropIndex(['signout_lng']);
            $table->dropIndex(['out_remark']);
        });
    }
};
