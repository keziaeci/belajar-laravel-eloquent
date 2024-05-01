<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = new Customer();
        $category->id = 'RENA';
        $category->name = 'Rena';
        $category->email = 'rena@gmail.com';
        $category->save();
    }
}
