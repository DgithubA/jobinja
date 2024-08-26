<?php

use App\Models\CareerPreference;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {


    const TableName = CareerPreference::table_name;
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create(self::TableName, function (Blueprint $table) {
            $table->id();
            $table->foreignId('resoum_id')->unique()->constrained(\App\Models\UserResoum::table_name)->onDelete('cascade');
            $table->set('states',config('constants.states'))->nullable();//استان های مورد علاقه
            $table->set('job_classification',config('constants.job_classification'))->nullable();//دسته‌بندی شغلی
            $table->set('level_of_activity',config('constants.level_of_activity'))->nullable();//سطح ارشدیت در زمینه فعالیت(تازه کار,متخصص,مدیر,مدیر ارشد)
            $table->set('types_of_acceptable_contracts',config('constants.types_of_acceptable_contracts'))->nullable();//نوع قرار داد های قابل قبول
            $table->string('minimum_salary_requested');//حداقل حقوق درخواستی
            $table->set('desired_job_benefits',config('constants.desired_job_benefits'))->nullable();//ترجیحات شغلی
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
