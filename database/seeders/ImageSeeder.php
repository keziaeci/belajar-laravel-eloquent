<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $img = new Image();
            $img->url = 'https://pin.it/2uGiO7hR6';
            $img->imageable_id = 'RENA';
            $img->imageable_type = 'customer';
            // $img->imageable_type = Customer::class;
            $img->save();
        }
        {
            $img = new Image();
            $img->url = 'https://pin.it/AlWCh81r6';
            $img->imageable_id = '1';
            $img->imageable_type = 'product';
            // $img->imageable_type = Product::class;
            $img->save();
        }
    }
}
