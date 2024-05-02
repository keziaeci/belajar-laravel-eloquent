<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $review = new Review();
        $review->product_id = '1';
        $review->customer_id = 'RENA';
        $review->rating = 5;
        $review->comment = 'Bagus Banget';
        $review->save();
        
        $review2 = new Review();
        $review2->product_id = '2';
        $review2->customer_id = 'RENA';
        $review2->rating = 3;
        $review2->comment = 'Bagus';
        $review2->save();
    }
}
