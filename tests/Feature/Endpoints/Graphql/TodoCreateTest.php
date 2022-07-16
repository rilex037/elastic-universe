<?php

namespace Tests\Feature\Endpoints\Graphql;

use Tests\Feature\FeatureSetup;

class TodoCreateTest extends FeatureSetup
{
  public function testQueryTodoCreate(): void
  {
    $response = $this->graphQL(
      /** @lang GraphQL */
      '
      mutation {
        createTodo(
          dueOn: "2022-12-21 21:00:00"
          userId: 222
          title: "This is a Todo Title"
          status: pending
        ) {
          id
          dueOn
          userId
          title
          status
        }
      }
    '
    );

    $response->assertJsonFragment(['title' => 'This is a Todo Title']);
    sleep(1);
  }
}
