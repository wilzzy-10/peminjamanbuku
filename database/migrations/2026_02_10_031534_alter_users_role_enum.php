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
        // Change the role enum to include 'member'
        DB::statement("ALTER TABLE users CHANGE COLUMN role role ENUM('user', 'member', 'petugas', 'admin') NOT NULL DEFAULT 'user'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum values
        DB::statement("ALTER TABLE users CHANGE COLUMN role role ENUM('user', 'petugas', 'admin') NOT NULL DEFAULT 'user'");
    }
};
