<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::updateOrCreate(['name'=>'Basic'],['name'=>'Basic','price'=>50,'duration'=>30,'data_limit'=>5,'description'=>'5 peoples of data']);
        Plan::updateOrCreate(['name'=>'Gold'],['name'=>'Gold','price'=>75,'duration'=>30,'data_limit'=>10,'description'=>'10 peoples of data']);
        Plan::updateOrCreate(['name'=>'Diamond'],['name'=>'Diamond','price'=>99,'duration'=>30,'data_limit'=>20,'description'=>'20 peoples of data']);
    }
}
