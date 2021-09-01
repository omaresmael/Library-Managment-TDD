<?php

namespace Tests\Unit;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function only_name_is_required()
    {

        Author::firstOrCreate([
            'name' =>'john dou'
        ]);

        $this->assertCount(1,Author::all());
    }
}
