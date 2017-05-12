<?php

namespace Tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class RatingControllerTest extends WebTestCase
{
    /** @test */
    public function it_receive_valid_response_for_page_rating_status()
    {
        $fixtures = $this->loadFixtures([
            'AppBundle\DataFixtures\ORM\LoadUriData',
        ])->getReferenceRepository();

        $data = [
            'uri' => 'http://'.$fixtures->getReference('first-uri')->getUri(),
        ];

        $response = $this->clientPost('/api/rating', [
            'data' => $data,
        ]);

        $this->assertJsonResponse($response, 200);

        $expected = [
            'status' => 'success',
            'data'   => [
                'uri'   => 'example.com/index',
                'score' => $fixtures->getReference('first-uri')->getScore(),
            ],
        ];

        $this->assertArraySubset($expected, $this->getJsonResponse($response));
    }

    /** @test */
    public function it_receive_valid_response_if_there_is_no_page_rating()
    {
        $data = [
            'uri' => 'http://dummy.org/new/site',
        ];

        $response = $this->clientPost('/api/rating', [
            'data' => $data,
        ]);

        $this->assertJsonResponse($response, 200);

        $expected = [
            'status' => 'success',
            'data'   => [
                'uri'   => 'dummy.org/new/site',
                'score' => 0,
            ],
        ];

        $this->assertArraySubset($expected, $this->getJsonResponse($response));
    }

    /** @test */
    public function it_receive_valid_responsea_when_vote_is_submitted()
    {
        $fixtures = $this->loadFixtures([
            'AppBundle\DataFixtures\ORM\LoadUriData',
        ])->getReferenceRepository();

        $data = [
            'uri'        => 'http://'.$fixtures->getReference('first-uri')->getUri(),
            'visitor_id' => '8b5fe7',
            'rating'     => 7,
        ];

        $this->assertEquals(
            5.50,
            $fixtures->getReference('first-uri')->getScore()
        );

        $response = $this->clientPost('/api/rating/vote', [
            'data' => $data,
        ]);

        $this->assertJsonResponse($response, 200);

        $expected = [
            'status' => 'success',
            'data'   => [
                'uri'   => $fixtures->getReference('first-uri')->getUri(),
                'score' => 6,
            ],
        ];

        $this->assertArraySubset($expected, $this->getJsonResponse($response));
    }

    protected function clientPost($url, $data)
    {
        $client = $this->makeClient();
        $client->request(
            'POST',
            $url,
            $data,
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        return $client->getResponse();
    }

    protected function getJsonResponse($response)
    {
        return $jsonResponse = json_decode($response->getContent(), true);
    }

    protected function assertJsonResponse($response, $statusCode = 200)
    {
        $this->assertEquals(
            $statusCode, $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }
}
