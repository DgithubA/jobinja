<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    const TableName = \App\Models\WorkExp::table_name;
    public function up(): void
    {
        Schema::create(self::TableName, function (Blueprint $table) {
            $table->id();
            $table->foreignId('resoum_id')->constrained(\App\Models\UserResoum::table_name)->onDelete('cascade');
            $table->string('job_title');
            $table->string('company_name')->nullable();
            //$table->foreignId('mytime_id')->constrained(\App\Models\MyTime::table_name)->onDelete('cascade');
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TableName);
    }
};
