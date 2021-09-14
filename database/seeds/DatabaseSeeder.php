<?php

use Illuminate\Database\Seeder;
use App\Models\NewsModel;

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
        factory(NewsModel::class, 50)->create();
        
    }
}
