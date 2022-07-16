<?php

namespace Tests\Feature\Endpoints\Graphql;

use Tests\Feature\FeatureSetup;

class PostDeleteTest extends FeatureSetup
{
  /**
   * @depends Tests\Feature\Endpoints\Graphql\PostEditTest::testQueryPostEdit
   */
  public function testQueryPostDelete(): void
  {
    $response = $this->graphQL(
      /** @lang GraphQL */
      '
      mutation {
        deletePost(
          id: "' . $this->getId('posts')['data']['posts']['data'][0]['id'] . '"
        )
      }
    '
    );
    $response->assertJsonStructure(['data' => ['deletePost']]);
  }

  public function testQueryPostDeleteError(): void
  {
    $response = $this->graphQL(
      /** @lang GraphQL */
      '
      mutation {
        deletePost(id: "some_id")
      }
    '
    );
    $response->assertJsonStructure(['errors']);
  }
}
