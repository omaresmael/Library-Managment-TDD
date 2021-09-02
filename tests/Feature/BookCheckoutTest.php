<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookCheckoutTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_book_can_be_checked_out_by_a_signed_in_user()
    {
        $this->withoutExceptionHandling();
        $book = Book::factory()->create();
        $this->actingAs($user = User::factory()->create())
        ->post('/checkout/'.$book->id);

        $this->assertCount(1,Reservation::all());
        $this->assertEquals($user->id,Reservation::first()->user_id);
        $this->assertEquals($user->id,Reservation::first()->book_id);
        $this->assertEquals(now(),Reservation::first()->checked_out_at);
    }

    /** @test */
    public function unsigned_user_cant_checkout_book()
    {

        $book = Book::factory()->create();
        $this->post('/checkout/'.$book->id)
        ->assertRedirect('/login');

        $this->assertCount(0,Reservation::all());

    }
    /** @test */
    public function only_real_books_can_be_checked_out()
    {
        $this->actingAs($user = User::factory()->create())
            ->post('/checkout/12783')
            ->assertStatus(404);

        $this->assertCount(0, Reservation::all());
    }

    /** @test */
    public function book_can_be_checked_in_by_a_signed_in_user()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();
        $this->actingAs($user)
            ->post('/checkout/' . $book->id);

        $this->actingAs($user)
            ->post('/checkin/' . $book->id);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);
        $this->assertEquals(now(), Reservation::first()->checked_in_at);
    }
}
