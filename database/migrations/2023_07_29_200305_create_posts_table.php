<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    const TableName = \App\Models\Post::table_name;
    public function up(): void{
        Schema::create(self::TableName, function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(\App\Models\User::table_name)->onDelete('cascade');
            $table->enum('status',config('constants.post_status'));
            $table->string('title');
            $table->enum('type',config('constants.post_type'));
            $table->set('job_classification',config('constants.job_classification'));//دسته بندی شغلی
            $table->longText('description')->default('empty');
            //optional
            $table->set('type_of_cooperation',config('constants.types_of_acceptable_contracts'))->nullable();//نوع همکاری
            $table->string('benefit')->nullable();//حقوق
            $table->string('states')->nullable();//مکان
            $table->string('work_experience')->nullable();//سابقه کار
            $table->longText('job_position')->nullable();// شرح موقعیت شغل مانند دانش تخصصی و مهارت های مورد نیاز و امتیازی و مزایای همکاری
            $table->enum('required_gender',config('constants.gender'))->nullable()->default('notmetter');
            $table->set('acceptable_military_service_status',config('constants.military_service_status'))->nullable();//وضعیت نظام وظیفه
            $table->enum('minimum_education_degree',config('constants.grades'))->nullable();//حداقل مقطع تحصیلی
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
