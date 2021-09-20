<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Developer;

class DeveloperTest extends TestCase
{
    use RefreshDatabase;

    private const BASE_URL = "api/developers";
    private const PAGINATION_JSON_STRUCTURE = [
        "current_page",
        "data" => [
            '*' => [
                "id",
                "name",
                "sex",
                "age",
                "hobby",
                "birth_date",
                "created_at",
                "updated_at",
            ]
        ],
        "first_page_url",
        "from",
        "last_page",
        "last_page_url",
        "links" => [
            '*' => [
                "url",
                "label",
                "active",
            ]
        ],
        "next_page_url",
        "path",
        "per_page",
        "prev_page_url",
        "to",
        "total"
    ];
    
    public function test_should_return_developers_with_pagination()
    {
        $developer = Developer::factory()->create();

        $response = $this->get(static::BASE_URL);

        $response->assertStatus(200);
        $response->assertJsonStructure(static::PAGINATION_JSON_STRUCTURE);
    }

    public function test_should_return_none_developers()
    {
        $developer = Developer::factory()->create();

        $response = $this->get(static::BASE_URL . "?sex=A");

        $response->assertStatus(200);
        $response->assertJsonCount(0, "data");
        $response->assertJsonStructure(static::PAGINATION_JSON_STRUCTURE);
    }

    public function test_should_return_developers_filter_by_name()
    {
        $developer1 = Developer::factory()->create([
            'name' => 'Ricardo Ishida',
        ]);
        $developer2 = Developer::factory()->create([
            'name' => 'Andre Felipe',
        ]);
        $developer3 = Developer::factory()->create([
            'name' => 'Ricardo da Silva',
        ]);

        $response = $this->get(static::BASE_URL . '?name=Ricardo');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
        $response->assertJsonStructure(static::PAGINATION_JSON_STRUCTURE);
    }

    public function test_should_return_developers_filter_by_sex()
    {
        $developer1 = Developer::factory()->create([
            'sex' => 'M',
        ]);
        $developer2 = Developer::factory()->create([
            'sex' => 'M',
        ]);
        $developer3 = Developer::factory()->create([
            'sex' => 'F',
        ]);

        $response = $this->get(static::BASE_URL . '?sex=F');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonStructure(static::PAGINATION_JSON_STRUCTURE);
    }

    public function test_should_return_developers_filter_by_age()
    {
        $developer1 = Developer::factory()->create([
            'age' => 18,
        ]);
        $developer2 = Developer::factory()->create([
            'age' => 20,
        ]);
        $developer3 = Developer::factory()->create([
            'age' => 25,
        ]);

        $response = $this->get(static::BASE_URL . '?age=25');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonStructure(static::PAGINATION_JSON_STRUCTURE);
    }

    public function test_should_return_developers_filter_by_hobby()
    {
        $developer1 = Developer::factory()->create([
            'hobby' => 'futebol',
        ]);
        $developer2 = Developer::factory()->create([
            'hobby' => 'futebol',
        ]);
        $developer3 = Developer::factory()->create([
            'hobby' => 'basquete',
        ]);

        $response = $this->get(static::BASE_URL . '?hobby=futebol');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
        $response->assertJsonStructure(static::PAGINATION_JSON_STRUCTURE);
    }

    public function test_should_return_developers_filter_by_birth_date()
    {
        $developer1 = Developer::factory()->create([
            'birth_date' => '1988-11-15',
        ]);
        $developer2 = Developer::factory()->create([
            'birth_date' => '1994-10-03',
        ]);
        $developer3 = Developer::factory()->create([
            'birth_date' => '2001-05-28',
        ]);

        $response = $this->get(static::BASE_URL . '?birth_date=2001-05-28');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonStructure(static::PAGINATION_JSON_STRUCTURE);
    }

    public function test_should_return_developer()
    {
        $developer1 = Developer::factory()->create();

        $response = $this->get(static::BASE_URL . '/1');

        $response->assertStatus(200);
        $response->assertJson($developer1->toArray());
        $this->assertModelExists($developer1);
    }

    public function test_should_not_return_developer()
    {
        $developer = Developer::factory()->create();

        $response = $this->get(static::BASE_URL . '/123');
        $response->assertStatus(404);
    }

    public function test_should_return_required_validation_errors_on_create_developer()
    {
        $data = [];
        $validationErrors = [
            "name",
            "sex",
            "age",
            "hobby",
            "birth_date"
        ];

        $response = $this->postJson(static::BASE_URL, $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors($validationErrors);
    }

    public function test_should_return_birth_date_validation_errors_on_create_developer()
    {
        $data = ["birth_date" => "11-01-2015"];
        $validationErrors = ["birth_date"];

        $response = $this->postJson(static::BASE_URL, $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors($validationErrors);
    }

    public function test_should_create_developer()
    {
        $data = Developer::factory()->make()->toArray();
        $response = $this->postJson(static::BASE_URL, $data);

        $response->assertStatus(201);
        $response->assertJson($data);
        $this->assertDatabaseHas('developers', $data);
    }

    public function test_should_return_required_validation_errors_on_update_developer()
    {
        $data = [];
        $validationErrors = [
            "name",
            "sex",
            "age",
            "hobby",
            "birth_date"
        ];

        $response = $this->postJson(static::BASE_URL, $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors($validationErrors);
    }

    public function test_should_return_birth_date_validation_errors_on_update_developer()
    {
        $data = ["birth_date" => "11-01-2015"];
        $validationErrors = ["birth_date"];

        $response = $this->putJson(static::BASE_URL . '/2', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors($validationErrors);
    }

    public function test_should_return_http_code_400_if_not_find_developer_on_update()
    {
        $developer = Developer::factory()->create();
        $data = Developer::factory()->make()->toArray();

        $response = $this->putJson(static::BASE_URL . '/2', $data);

        $response->assertStatus(400);
        $this->assertDatabaseHas('developers', [
            'name' => $developer->name,
        ]);
        $this->assertDatabaseMissing('developers', [
            'name' => 'Fernando Ferreira',
        ]);
    }

    public function test_should_update_developer()
    {
        $developer = Developer::factory()->create();
        $data = Developer::factory()->make()->toArray();

        $response = $this->putJson(static::BASE_URL . '/1', $data);

        $response->assertStatus(200);
        $response->assertJson($data);
        $this->assertDatabaseHas('developers', $data);
        $this->assertDatabaseMissing('users', $developer->toArray());
    }

    public function test_should_return_http_code_400_if_not_delete_developer()
    {
        $developer = Developer::factory()->create();
        
        $response = $this->delete(static::BASE_URL . '/2');

        $response->assertStatus(400);
    }

    public function test_should_delete_developer()
    {
        $developer = Developer::factory()->create();
        
        $response = $this->delete(static::BASE_URL . '/1');

        $response->assertStatus(204);
    }
}
