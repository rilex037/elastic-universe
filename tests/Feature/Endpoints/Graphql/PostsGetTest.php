<?php

namespace Tests\Feature\Endpoints\Graphql;

use Tests\Feature\FeatureSetup;

class PostsGetTest extends FeatureSetup
{
  /**
   * @depends Tests\Feature\Endpoints\Graphql\PostCreateTest::testQueryPostCreate
   */
  public function testQueryPostsGet(): void
  {
    $response = $this->graphQL(
      /** @lang GraphQL */
      '
      query {
        posts(
          body: "*"
          title: "*"
          userId:123,
          page: 1
          perPage: 10
        ) {
          page
          perPage
          records
          totalPages
          data {
            id
            body
            title
            userId
          }
        }
      }
    '
    );

    $response->assertJsonFragment(['body' => 'Lorem ipsum dolor sit amet']);
  }
}
