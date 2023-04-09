<?php

namespace Tests\Feature;

use App\Models\Book;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->app['config']->set('database.default', 'mongodb');
    }

    /** @test */
    public function can_get_all_books()
    {
        $books = Book::factory()->count(5)->create();

        $response = $this->getJson('/api/books');

        $response->assertOk();
        $response->assertJsonCount(5);
    }

    /** @test */
    public function can_create_a_book()
    {
        $bookData = [
            'title' => 'Book 1',
            'content' => 'text text text',
        ];

        $response = $this->postJson('/api/books', $bookData);

        $response->assertStatus(201);
        $response->assertJsonFragment($bookData);
    }

    /** @test */
    public function can_get_a_book()
    {
        $book = Book::factory()->create();

        $response = $this->getJson('/api/books/'.$book->id);

        $response->assertOk();
        $response->assertJsonFragment($book->toArray());
    }

    /** @test */
    public function can_update_a_book()
    {
        $book = Book::factory()->create();

        $updatedBookData = [
            'title' => 'Updated Book 1',
            'content' => 'Updated text text text',
        ];

        $response = $this->putJson('/api/books/'.$book->id, $updatedBookData);

        $response->assertOk();
        $this->assertDatabaseHas('books', $updatedBookData);
        $response->assertJsonFragment($updatedBookData);
    }

    /** @test */
    public function can_delete_a_book()
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson('/api/books/'.$book->id);

        $response->assertNoContent();
        $this->assertModelMissing($book);
    }
}
