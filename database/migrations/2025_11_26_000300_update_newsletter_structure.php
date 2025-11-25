<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('newsletter', function (Blueprint $table) {
            if (!Schema::hasColumn('newsletter', 'email')) {
                return;
            }

            $duplicateEmails = DB::table('newsletter')
                ->select('email')
                ->groupBy('email')
                ->havingRaw('COUNT(*) > 1')
                ->pluck('email');

            foreach ($duplicateEmails as $email) {
                $duplicateIds = DB::table('newsletter')
                    ->where('email', $email)
                    ->orderBy('id')
                    ->pluck('id');

                $idsToDelete = $duplicateIds->slice(1);

                if ($idsToDelete->isNotEmpty()) {
                    DB::table('newsletter')
                        ->whereIn('id', $idsToDelete)
                        ->delete();
                }
            }

            $table->unique('email');
        });

        Schema::create('category_newsletter', function (Blueprint $table) {
            $table->id();
            $table->foreignId('newsletter_id')->constrained('newsletter')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['newsletter_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_newsletter');

        Schema::table('newsletter', function (Blueprint $table) {
            $table->dropUnique('newsletter_email_unique');
        });
    }
};
