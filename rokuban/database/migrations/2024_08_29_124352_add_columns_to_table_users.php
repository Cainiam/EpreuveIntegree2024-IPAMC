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
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('password');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('address_line_1')->nullable()->after('last_name');
            $table->string('address_line_2')->nullable()->after('address_line_1');
            $table->string('postal_code')->nullable()->after('address_line_2');
            $table->string('city')->nullable()->after('postal_code');
            $table->foreignId('role_id')->default(2)->after('city')->constrained(table: 'roles', indexName: 'user_role_id'); //2 = normal user "client"
            $table->boolean('isActive')->default(1)->after('role_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('address_line_1');
            $table->dropColumn('address_line_2');
            $table->dropColumn('postal_code');
            $table->dropColumn('city');
            $table->dropColumn('role_id');
            $table->dropColumn('isActive');
        });
    }
};
