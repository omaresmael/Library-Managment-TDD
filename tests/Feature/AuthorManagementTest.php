<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function author_can_be_created()
    {

        $response = $this->post('/authors',[
            'name' => 'vector',
            'dob' => '12/05/1998'
        ]);
        $authors = Author::all();
        $response->assertOk();
        $this->assertCount(1,$authors);

        $this->assertInstanceOf(Carbon::class,$authors->first()->dob);
        $this->assertEquals('1998/05/12',$authors->first()->dob->format('Y/d/m'));

    }
}
