<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\CareerPreference;
use App\Models\CompanyInfo;
use App\Models\MyTime;
use App\Models\ContactsInfo;
use App\Models\Post;
use App\Models\studyexp;
use App\Models\User;
use App\Models\UserResoum;
use App\Models\WorkExp;
use Faker\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder{
    /**
     * Seed the application's database.
     */

    public function run(): void{
        ///$this->truncateAllTables();
        //$this->makeadmin();
        //$this->makeuserswithresoum(1);
        $this->makeposts(40);
    }

    public function makeadmin(int $count = 1){
        Admin::factory($count)->create();
    }
    public function makeuserswithresoum(int $count = 10,bool $truncate = false){

        if($truncate) $this->truncateAllTables();

        User::factory($count)->has(ContactsInfo::factory(1))->has(Post::factory(2))->afterCreating(function (User $user){
            if($user->type === 'personally'){
                $saveresoum_id = UserResoum::factory(1)
                    ->has(CareerPreference::factory(1))
                    ->has( WorkExp::factory(1)->has( MyTime::factory(1)) )
                    ->has( StudyExp::factory(1)->has( MyTime::factory(1)) )
                    ->create(['user_id'=>$user->id])
                    ->toArray()[0]['id'];
            }else $saveresoum_id = CompanyInfo::factory(1)->create(['user_id'=>$user->id])->toArray()[0]['id'];
            $user->resoum_id = $saveresoum_id;
            $user->save();
        })->create();
    }

    /**
     * @param string[] $tables tables name.
     * @return void
     */
    public function droptables(array $tables = []){
        if(empty($tables)){
            Schema::dropAllTables();
        }else{
            foreach ($tables as $table){
                Schema::dropIfExists($table);
            }
        }
    }

    public function truncateAllTables($foreignKeyCheck = true){
        if($foreignKeyCheck) DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MyTime::truncate();
        WorkExp::truncate();
        StudyExp::truncate();
        CareerPreference::truncate();
        UserResoum::truncate();
        CompanyInfo::truncate();
        ContactsInfo::truncate();
        Post::truncate();
        User::truncate();
        if ($foreignKeyCheck) DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }

    public function makeposts(int $count = 10,bool $truncate = false){
        $user_ids = User::all(['id'])->toArray();
        if(empty($user_ids)) throw new \Exception("no user exist");
        if($truncate) Post::truncate();
        //dd($user_ids[array_rand($user_ids)]['id']);

        $post = Post::factory($count)->afterCreating(function (Post $post) use ($user_ids){
            $random_user_id = $user_ids[array_rand($user_ids)]['id'];
            $post->user_id = $random_user_id;
            $post->save();
        })->create(['user_id'=>1]);
        //dd($post->toArray());
        //post::create($post->toArray()[0]);
    }

}
