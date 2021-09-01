<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_book_can_be_added_to_the_library()
    {

        $response =$this->post('/books', [
            'title'=>'a cool book',
            'author' => 'victor',
        ]);
        $response->assertOk();
        $this->assertCount(1,Book::all());
    }

    /** @test */
    public function title_is_required()
    {
        //$this->withoutExceptionHandling();
        $response =$this->post('/books', [
            'title'=>'',
            'author' => 'victor',
        ]);
        $response->assertSessionHasErrors('title');

    }
    /** @test */
    public function author_is_required()
    {
        //$this->withoutExceptionHandling();
        $response =$this->post('/books', [
            'title'=>'test',
            'author' => '',
        ]);
        $response->assertSessionHasErrors('author');

    }
    /** @test */
    public function a_book_can_be_updated_to_the_library()
    {
        $this->withoutExceptionHandling();
        $this->post('/books', [
            'title'=>'a cool book',
            'author' => 'victor',
        ]);
        $book = Book::first();
         $this->patch('/books/'.$book->id, [
            'title'=>'a new cool book',
            'author' => 'victor',
        ]);


        $this->assertEquals('a new cool book',Book::first()->title);
    }
}
