<?php

namespace Tests\Feature\Endpoints\Graphql;

use Tests\Feature\FeatureSetup;

class TodosGetTest extends FeatureSetup
{
  /**
   * @depends Tests\Feature\Endpoints\Graphql\TodoCreateTest::testQueryTodoCreate
   */
  public function testQueryTodosGet(): void
  {
    $response = $this->graphQL(
      /** @lang GraphQL */
      '
      query {
        todos(
          dueOn: "2022-12-21 21:00:00"
          title: "*"
          status: "*"
          userId: 222
          page: 1
          perPage: 10
        ) {
         page
          perPage
          records
          totalPages
          data {
            id
            dueOn
            title
            status
            userId
          }
        }
      }
    '
    );

    $response->assertJsonFragment(['title' => 'This is a Todo Title']);
  }
}
