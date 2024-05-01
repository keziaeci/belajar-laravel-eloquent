<?php

namespace Tests\Feature;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertNotNull;

class CommentTest extends TestCase
{
    function testCreateComment() {
        $comment = new Comment();
        $comment->email = 'rena@gmail.com';
        $comment->title = 'Sample Title';
        $comment->comment = 'Sample comment';
        $comment->save();

        assertNotNull($comment->id);
    }

    function testDefaultAttributeValues() {
        $comment = new Comment();
        $comment->email = 'rena@gmail.com';
        $comment->save();
        
        assertNotNull($comment->title);
        assertNotNull($comment->comment);
    }

}
