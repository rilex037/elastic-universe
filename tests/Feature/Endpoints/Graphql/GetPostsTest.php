<?php

namespace Tests\Feature\Endpoints\Graphql;

use Tests\Feature\FeatureSetup;

class GetPostsTest extends FeatureSetup
{


  /**
   * @depends testQueryPostCreate
   */
  public function testQueryPosts(): void
  {
    sleep(1);
    $response = $this->graphQL(
      /** @lang GraphQL */
      '
        query {
            posts(
              body: "*"
              title: "*"
          
              page: 1
              perPage: 500
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
  }
}
