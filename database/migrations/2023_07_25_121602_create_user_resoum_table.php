<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    const TableName = \App\Models\UserResoum::table_name;
    public function up(): void{

        Schema::create(self::TableName, function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->boolean('public')->default(0);
            $table->longText('likes')->default('0');
            $table->string('job_title')->nullable();//now job[without job, student ,....]
            $table->enum('job_status',config('constants.job_status'))->default('Looking for a job');
            //Professional skills
            $table->set('expertise_category',config('constants.job_classification'))->nullable();
            $table->string('skills')->nullable();//مهارت ها
            $table->integer('years_of_birthday')->nullable();//تولد
            $table->string('languages')->nullable();//زبان ها
            //$table->integer('CareerPreferences_id')->nullable();//ترجیحات شغلی
            $table->longText('about')->nullable();
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
