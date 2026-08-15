<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->index(['is_active', 'published_at', 'sort_order'], 'portfolios_active_pub_sort_idx');
            $table->index(['is_active', 'sort_order'], 'portfolios_active_sort_idx');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order'], 'services_active_sort_idx');
        });

        Schema::table('home_stats', function (Blueprint $table) {
            $table->index('sort_order', 'home_stats_sort_idx');
        });

        Schema::table('advantages', function (Blueprint $table) {
            $table->index('sort_order', 'advantages_sort_idx');
        });

        Schema::table('pricing_plans', function (Blueprint $table) {
            $table->index(['sort_order', 'is_popular'], 'pricing_plans_sort_pop_idx');
        });

        Schema::table('pricing_features', function (Blueprint $table) {
            $table->index(['pricing_plan_id', 'sort_order'], 'pricing_features_plan_sort_idx');
        });

        Schema::table('service_features', function (Blueprint $table) {
            $table->index(['service_id', 'sort_order'], 'service_features_srv_sort_idx');
        });

        Schema::table('portfolio_sections', function (Blueprint $table) {
            $table->index(['portfolio_id', 'sort_order'], 'portfolio_sections_port_sort_idx');
        });

        Schema::table('contact_messages', function (Blueprint $table) {
            $table->index('created_at', 'contact_messages_created_idx');
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropIndex('contact_messages_created_idx');
        });

        Schema::table('portfolio_sections', function (Blueprint $table) {
            $table->dropIndex('portfolio_sections_port_sort_idx');
        });

        Schema::table('service_features', function (Blueprint $table) {
            $table->dropIndex('service_features_srv_sort_idx');
        });

        Schema::table('pricing_features', function (Blueprint $table) {
            $table->dropIndex('pricing_features_plan_sort_idx');
        });

        Schema::table('pricing_plans', function (Blueprint $table) {
            $table->dropIndex('pricing_plans_sort_pop_idx');
        });

        Schema::table('advantages', function (Blueprint $table) {
            $table->dropIndex('advantages_sort_idx');
        });

        Schema::table('home_stats', function (Blueprint $table) {
            $table->dropIndex('home_stats_sort_idx');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex('services_active_sort_idx');
        });

        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropIndex('portfolios_active_pub_sort_idx');
            $table->dropIndex('portfolios_active_sort_idx');
        });
    }
};
