<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    const TableName = \App\Models\User::table_name;

    public function up(): void{
        Schema::create(self::TableName, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('key')->unique();
            $table->enum('type',config('constants.user_type'))->default('personally');
            $table->integer('resoum_id')->unsigned()->nullable();

            $table->integer('contactsInfo_id')->unique()->nullable();//
            $table->string('password');
            $table->rememberToken();
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
