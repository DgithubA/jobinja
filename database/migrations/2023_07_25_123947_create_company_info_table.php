<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    const TableName = \App\Models\CompanyInfo::table_name;
    public function up(): void
    {
        Schema::create(self::TableName, function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->longText('likes')->default('0');
            $table->set('category',config('constants.job_classification'))->nullable();
            $table->integer('number_of_ex')->default(0);
            $table->timestamp('build_year')->nullable();
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
