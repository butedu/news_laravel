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
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('attachment_path')->nullable()->after('message');
            $table->string('attachment_original_name')->nullable()->after('attachment_path');
            $table->string('attachment_mime')->nullable()->after('attachment_original_name');
            $table->timestamp('last_replied_at')->nullable()->after('read_at');
            $table
                ->foreignId('last_replied_by')
                ->nullable()
                ->after('last_replied_at')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign(['last_replied_by']);
            $table->dropColumn([
                'attachment_path',
                'attachment_original_name',
                'attachment_mime',
                'last_replied_at',
                'last_replied_by',
            ]);
        });
    }
};
