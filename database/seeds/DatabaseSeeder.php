<?php

use Illuminate\Database\Seeder;
use App\Models\NewsModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        for($i=1;$i<200;$i++){
            DB::table('news')->insert(
                [
                    'userid' => 1,
                    'title' => Str::random(10),
                    'description' => Str::random(40),
                    'likes' => 0,
                ]
            );
        }
    }
    
}
