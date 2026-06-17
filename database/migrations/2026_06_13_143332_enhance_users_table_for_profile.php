<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'nama')) {
                $table->string('nama')->nullable()->after('id');
            }
            if (!Schema::hasColumn('users', 'prodi')) {
                $table->string('prodi')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'semester')) {
                $table->unsignedTinyInteger('semester')->nullable()->after('prodi');
            }
            if (!Schema::hasColumn('users', 'nim')) {
                $table->string('nim')->nullable()->unique()->after('semester');
            }
            if (!Schema::hasColumn('users', 'angkatan')) {
                $table->unsignedSmallInteger('angkatan')->nullable()->after('nim');
            }
            if (!Schema::hasColumn('users', 'photo')) {
                $table->string('photo')->nullable()->after('angkatan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nama', 'prodi', 'semester', 'nim', 'angkatan', 'photo']);
        });
    }
};
