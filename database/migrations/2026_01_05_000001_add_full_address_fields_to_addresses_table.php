<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('province_id')->nullable();
            $table->string('province_name')->nullable();
            $table->string('city_id')->nullable();
            $table->string('city_name')->nullable();
            $table->string('district_id')->nullable();
            $table->string('district_name')->nullable();
            $table->string('subdistrict_id')->nullable();
            $table->string('subdistrict_name')->nullable();
            $table->string('postal_code')->nullable();
            $table->text('extra_detail')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'province_id',
                'province_name',
                'city_id',
                'city_name',
                'district_id',
                'district_name',
                'subdistrict_id',
                'subdistrict_name',
                'postal_code',
                'extra_detail',
            ]);
        });
    }
};
