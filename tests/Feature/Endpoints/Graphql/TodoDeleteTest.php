<?php

namespace Tests\Feature\Endpoints\Graphql;

use Tests\Feature\FeatureSetup;

class TodoDeleteTest extends FeatureSetup
{
  /**
   * @depends Tests\Feature\Endpoints\Graphql\TodoEditTest::testQueryTodoEdit
   */
  public function testQueryTodoDelete(): void
  {
    $response = $this->graphQL(
      /** @lang GraphQL */
      '
      mutation {
        deleteTodo(
          id: "' . $this->getId('todos')['data']['todos']['data'][0]['id'] . '"
        )
      }
    '
    );
    $response->assertJsonStructure(['data' => ['deleteTodo']]);
  }

  public function testQueryTodoDeleteError(): void
  {
    $response = $this->graphQL(
      /** @lang GraphQL */
      '
      mutation {
        deleteTodo(id: "some_id")
      }
    '
    );
    $response->assertJsonStructure(['errors']);
  }
}
