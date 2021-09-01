<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
//        $this->withoutExceptionHandling();
    }


    /** @test */
    public function a_book_can_be_added_to_the_library()
    {

        $response = $this->post('/books', [
            'title'=>'a cool book',
            'author_id' => 'victor',
        ]);

        $this->assertCount(1,Book::all());
        $response->assertRedirect(Book::first()->path());
    }

    /** @test */
    public function title_is_required()
    {

        $response =$this->post('/books', [
            'title'=>'',
            'author_id' => 'victor',
        ]);
        $response->assertSessionHasErrors('title');

    }
    /** @test */
    public function author_id_is_required()
    {

        $response =$this->post('/books', [
            'title'=>'test',
            'author_id' => '',
        ]);
        $response->assertSessionHasErrors('author_id');

    }
    /** @test */
    public function a_book_can_be_updated()
    {

        $this->post('/books', [
            'title'=>'a cool book',
            'author_id' => 'victor',
        ]);
        $book = Book::first();
        $response = $this->patch('/books/'.$book->id, [
            'title'=>'a new cool book',
            'author_id' => 'victor',
        ]);
        $this->assertEquals('a new cool book',Book::first()->title);
        $response->assertRedirect(Book::first()->path());

    }

    /** @test */
    public function book_can_be_deleted()
    {

        $this->post('/books', [
            'title'=>'a cool book',
            'author_id' => 'victor',
        ]);
        $book = Book::first();
        $response = $this->delete('/books/'.$book->id);

        $this->assertCount(0,Book::all());
        $response->assertRedirect('/books');
    }
    /** @test */
    public function new_author_is_automatically_added()
    {
        $this->withoutExceptionHandling();
        $this->post('/books', [
            'title'=>'a cool book',
            'author_id' => 'victor',
        ]);

        $book = Book::first();

        $author = Author::first();
        $this->assertEquals($author->id,$book->author_id);
        $this->assertCount(1,Author::all());

    }
}
