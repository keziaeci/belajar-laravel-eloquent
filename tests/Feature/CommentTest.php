<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Comment;
use App\Models\Voucher;
use Illuminate\Foundation\Testing\WithFaker;

use function PHPUnit\Framework\assertNotNull;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    function testCreateComment() {
        $comment = new Comment();
        $comment->email = 'rena@gmail.com';
        $comment->title = 'Sample Title';
        $comment->comment = 'Sample comment';
        $comment->commentable_id = '1';
        $comment->commentable_type = Voucher::class;
        $comment->save();

        assertNotNull($comment->id);
    }

    function testDefaultAttributeValues() {
        $comment = new Comment();
        $comment->email = 'rena@gmail.com';
        $comment->commentable_id = '1';
        $comment->commentable_type = Voucher::class;
        $comment->save();
        
        assertNotNull($comment->title);
        assertNotNull($comment->comment);
    }

}
