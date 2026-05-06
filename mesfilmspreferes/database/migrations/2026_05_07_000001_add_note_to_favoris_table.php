<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('favoris', function (Blueprint $table) {
            $table->tinyInteger('note')->nullable()->after('avis');
        });
    }

    public function down(): void
    {
        Schema::table('favoris', function (Blueprint $table) {
            $table->dropColumn('note');
        });
    }
};
