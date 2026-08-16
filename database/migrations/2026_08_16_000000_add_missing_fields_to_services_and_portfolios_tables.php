<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('services') && ! Schema::hasColumn('services', 'cta_url')) {
            Schema::table('services', function (Blueprint $table) {
                $table->string('cta_url')->nullable()->after('cta_label');
            });
        }

        if (Schema::hasTable('portfolios') && ! Schema::hasColumn('portfolios', 'description')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->longText('description')->nullable()->after('excerpt');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('services') && Schema::hasColumn('services', 'cta_url')) {
            Schema::table('services', function (Blueprint $table) {
                $table->dropColumn('cta_url');
            });
        }

        if (Schema::hasTable('portfolios') && Schema::hasColumn('portfolios', 'description')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }
    }
};
