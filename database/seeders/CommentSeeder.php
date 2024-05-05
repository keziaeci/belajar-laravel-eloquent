<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $product = Product::first();
            $comment = new Comment();
            $comment->email = 'rena@gmail.com';
            $comment->title = 'Title';
            $comment->comment = 'comment product';
            $comment->commentable_id = $product->id;
            $comment->commentable_type = 'product';
            // $comment->commentable_type = Product::class;
            $comment->save();
        }
        {
            $voucher = Voucher::first();
            $comment = new Comment();
            $comment->email = 'rena@gmail.com';
            $comment->title = 'Title';
            $comment->comment = 'comment voucher';
            $comment->commentable_id = $voucher->id;
            $comment->commentable_type = 'voucher'; //mengganti string karena sudah ada alias di service profider
            // $comment->commentable_type = Voucher::class;
            $comment->save();
        }
    }
}
