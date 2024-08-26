<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const TableName = \App\Models\ContactsInfo::table_name;
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create(self::TableName, function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('telegram')->nullable();
            $table->string('web'     )->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists(self::TableName);
    }
};
