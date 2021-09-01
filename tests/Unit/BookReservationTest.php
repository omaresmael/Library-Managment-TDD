<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function book_can_be_checked_out()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $book->checkout($user);
        $this->assertCount(1,Reservation::all());
        $this->assertEquals($user->id,Reservation::first()->user_id);
        $this->assertEquals($user->id,Reservation::first()->book_id);
        $this->assertEquals(now(),Reservation::first()->checked_out_at);

    }
    /** @test */
    public function book_can_be_returned()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $book->checkout($user);
        $book->checkin($user);
        $this->assertCount(1,Reservation::all());
        $this->assertEquals($user->id,Reservation::first()->user_id);
        $this->assertEquals($user->id,Reservation::first()->book_id);
        $this->assertEquals(now(),Reservation::first()->checked_in_at);

    }
    /** @test */
    public function user_can_check_book_twice()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $book->checkout($user);
        $book->checkin($user);
        $book->checkout($user);
        $this->assertCount(2,Reservation::all());
        $this->assertEquals($user->id,Reservation::find(2)->user_id);
        $this->assertEquals($user->id,Reservation::find(2)->book_id);
        $this->assertEquals(now(),Reservation::find(2)->checked_out_at);

    }

    /** @test */
    public function if_not_checked_out_exception_is_thrown()
    {
        $this->expectException(\Exception::class);
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $book->checkin($user);


    }

}
