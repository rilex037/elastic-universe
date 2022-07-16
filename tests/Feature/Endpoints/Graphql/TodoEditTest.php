<?php

namespace Tests\Feature\Endpoints\Graphql;

use Tests\Feature\FeatureSetup;

class TodoEditTest extends FeatureSetup
{
  /**
   * @depends Tests\Feature\Endpoints\Graphql\TodosGetTest::testQueryTodosGet
   */
  public function testQueryTodoEdit(): void
  {
    $response = $this->graphQL(
      /** @lang GraphQL */
      '
      mutation {
        editTodo(
          id: "' . $this->getId('todos')['data']['todos']['data'][0]['id'] . '"
          dueOn: "2023-12-21 21:00:00"
          userId: 223
          title: "Updated Title"
          status: pending
        )
      }
    '
    );
    $response->assertJsonStructure(['data' => ['editTodo']]);
    sleep(1);
  }

  public function testQueryPostEditError(): void
  {
    $response = $this->graphQL(
      /** @lang GraphQL */
      '
      mutation {
        editTodo(
          id: "some_id"
          dueOn: "2023-12-21 21:00:00"
          userId: 223
          title: "Updated Title"
          status: pending
        )
      }
    '
    );
    $response->assertJsonStructure(['errors']);
  }
}
