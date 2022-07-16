<?php

namespace Tests\Feature\Endpoints\Graphql;

use Tests\Feature\FeatureSetup;

class PostEditTest extends FeatureSetup
{
  /**
   * @depends Tests\Feature\Endpoints\Graphql\PostsGetTest::testQueryPostsGet
   */
  public function testQueryPostEdit(): void
  {
    $response = $this->graphQL(
      /** @lang GraphQL */
      '
      mutation {
        editPost(
          id: "' . $this->getId('posts')['data']['posts']['data'][0]['id'] . '"
          body: "Nunc eu purus sit amet velit condimentum maximus."
          title: "Changed Title"
          userId: 123
        )
      }
    '
    );
    $response->assertJsonStructure(['data' => ['editPost']]);
    sleep(1);
  }

  public function testQueryPostEditError(): void
  {
    $response = $this->graphQL(
      /** @lang GraphQL */
      '
      mutation {
        editPost(
          id: "some_id"
          body: "Nunc eu purus sit amet velit condimentum maximus."
          title: "Changed Title"
          userId: 123
        )
      }
    '
    );
    $response->assertJsonStructure(['errors']);
  }
}
