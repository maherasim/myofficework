<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'activation_email_sent_at')) {
                $table->timestamp('activation_email_sent_at')->nullable()->after('remember_token');
            }
            if (!Schema::hasColumn('users', 'welcome_email_sent_at')) {
                $table->timestamp('welcome_email_sent_at')->nullable()->after('activation_email_sent_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'activation_email_sent_at')) {
                $table->dropColumn('activation_email_sent_at');
            }
            if (Schema::hasColumn('users', 'welcome_email_sent_at')) {
                $table->dropColumn('welcome_email_sent_at');
            }
        });
    }
};

