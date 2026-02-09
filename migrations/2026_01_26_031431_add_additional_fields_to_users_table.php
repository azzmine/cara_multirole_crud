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
            // Skip role_id karena sudah ada
            // $table->foreignId('role_id')->nullable()->after('id')->constrained('roles')->onDelete('cascade');

            $table->enum('gender', ['male', 'female'])->nullable()->after('password');
            $table->text('address')->nullable()->after('gender');
            $table->string('birth_place')->nullable()->after('address');
            $table->date('birth_date')->nullable()->after('birth_place');
            $table->string('phone', 15)->nullable()->after('birth_date');
            $table->string('photo')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Skip role_id karena kita tidak menambahkannya
            // $table->dropForeign(['role_id']);
            $table->dropColumn([
                // 'role_id', // skip ini
                'gender',
                'address',
                'birth_place',
                'birth_date',
                'phone',
                'photo'
            ]);
        });
    }
};
