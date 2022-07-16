<?php

namespace Tests\Feature\Endpoints\Graphql;

use Tests\Feature\FeatureSetup;

class PostCreateTest extends FeatureSetup
{
  public function testQueryPostCreate(): void
  {
    $response = $this->graphQL(
      /** @lang GraphQL */
      '
      mutation {
        createPost(
          body: "Lorem ipsum dolor sit amet"
          title: "This Is Post Title"
          userId: 123
        ) {
          id
          body
          title
          userId
        }
      }
    '
    );

    $response->assertJsonFragment(['body' => 'Lorem ipsum dolor sit amet']);
    sleep(1);
  }
}
