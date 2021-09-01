<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
   public function author_id_is_recorded()
   {
       Book::create([
           'title' => 'cool tilte',
           'author_id' => 1,
       ]);
       $this->assertCount(1,Book::all());
   }
}
