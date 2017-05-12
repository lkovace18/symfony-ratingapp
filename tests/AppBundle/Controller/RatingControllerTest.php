<?php

namespace Tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class RatingControllerTest extends WebTestCase {

	/** @test */
	public function it_receive_valid_response_for_page_rating_status() {
		$fixtures = $this->loadFixtures([
			'AppBundle\DataFixtures\ORM\LoadUriData',
		])->getReferenceRepository();

		$data = [
			'uri' => 'http://' . $fixtures->getReference('first-uri')->getUri(),
		];

		$response = $this->clientPost('/api/rating', [
			'data' => $data,
		]);

		$this->assertJsonResponse($response, 200);

		$expected = [
			'status' => 'success',
			'data' => [
				'uri' => 'example.com/index',
				'score' => $fixtures->getReference('first-uri')->getScore(),
			],
		];

		$this->assertArraySubset($expected, $this->getJsonResponse($response));
	}

	/** @test */
	public function it_receive_valid_response_if_there_is_no_page_rating() {
		$data = [
			'uri' => 'http://dummy.org/new/site',
		];

		$response = $this->clientPost('/api/rating', [
			'data' => $data,
		]);

		$this->assertJsonResponse($response, 200);

		$expected = [
			'status' => 'success',
			'data' => [
				'uri' => 'dummy.org/new/site',
				'score' => 0,
			],
		];

		$this->assertArraySubset($expected, $this->getJsonResponse($response));
	}

	/** @test */
	public function it_receive_valid_error_response_when_uri_data_is_missing() {
		$fixtures = $this->loadFixtures([
			'AppBundle\DataFixtures\ORM\LoadUriData',
		])->getReferenceRepository();

		$data = [
			'uri' => 'http://' . $fixtures->getReference('first-uri')->getUri(),
		];

		$response = $this->clientPost('/api/rating', []);

		$this->assertErrorJsonResponse($response, 400);

		$expected = [
			'status' => 'failure',
			'errors' => [],
		];

		$this->assertArraySubset($expected, $this->getJsonResponse($response));
	}

	/** @test */
	public function it_receive_valid_error_response_when_vote_data_is_missing() {
		$fixtures = $this->loadFixtures([
			'AppBundle\DataFixtures\ORM\LoadUriData',
		])->getReferenceRepository();

		$this->assertEquals(
			5.50,
			$fixtures->getReference('first-uri')->getScore()
		);

		$response = $this->clientPost('/api/rating/vote', []);

		$this->assertErrorJsonResponse($response, 400);

		$expected = [
			'status' => 'failure',
			'errors' => [],
		];

		$this->assertArraySubset($expected, $this->getJsonResponse($response));
	}

	/** @test */
	public function it_receive_valid_error_response_when_vote_rating_is_incorrect() {
		$fixtures = $this->loadFixtures([
			'AppBundle\DataFixtures\ORM\LoadUriData',
		])->getReferenceRepository();

		$data = [
			'uri' => 'http://' . $fixtures->getReference('first-uri')->getUri(),
		];

		$data = [
			'uri' => 'http://' . $fixtures->getReference('first-uri')->getUri(),
			'visitor_id' => '8b5fe7',
			'rating' => 100,
		];

		$response = $this->clientPost('/api/rating/vote', [
			'data' => $data,
		]);

		$this->assertErrorJsonResponse($response, 400);

		$expected = [
			'status' => 'failure',
			'errors' => [
				'validation' => [
					"rating" => "This value should be 10 or less.",
				],
			],
		];

		$this->assertArraySubset($expected, $this->getJsonResponse($response));
	}

	/** @test */
	public function it_receive_valid_response_when_vote_is_submitted() {
		$fixtures = $this->loadFixtures([
			'AppBundle\DataFixtures\ORM\LoadUriData',
		])->getReferenceRepository();

		$data = [
			'uri' => 'http://' . $fixtures->getReference('first-uri')->getUri(),
			'visitor_id' => '8b5fe7',
			'rating' => 7,
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
			'data' => [
				'uri' => $fixtures->getReference('first-uri')->getUri(),
				'score' => 6,
			],
		];

		$this->assertArraySubset($expected, $this->getJsonResponse($response));
	}

	protected function clientPost($url, $data) {
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

	protected function getJsonResponse($response) {
		return $jsonResponse = json_decode($response->getContent(), true);
	}

	protected function assertStatusCodeIsCorrect($response, $statusCode) {
		$this->assertEquals(
			$statusCode, $response->getStatusCode(),
			$response->getContent()
		);
	}

	protected function assertJsonResponse($response, $statusCode = 200) {
		$this->assertStatusCodeIsCorrect($response, $statusCode);
		$this->assertTrue(
			$response->headers->contains('Content-Type', 'application/json'),
			$response->headers
		);
	}

	protected function assertErrorJsonResponse($response, $statusCode = 400) {
		$this->assertStatusCodeIsCorrect($response, $statusCode);
		$this->assertTrue(
			$response->headers->contains('Content-Type', 'application/problem+json'),
			$response->headers
		);
	}
}
