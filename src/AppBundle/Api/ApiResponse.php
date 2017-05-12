<?php

namespace AppBundle\Api;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * A wrapper for building api response.
 */
class ApiResponse {
	/**
	 * @var int
	 */
	private $statusCode;

	/**
	 * @var array
	 */
	private $data = [];

	/**
	 * @var array
	 */
	private $errors = [];

	public function __construct(Int $statusCode, array $data) {
		$this->statusCode = $statusCode;
		$this->data = $data;
	}

	public function toArray() {
		if ($this->hasErrors()) {
			return array_merge(
				[
					'status' => 'faliure',
				],
				[
					'errors' => $this->errors,
				]
			);
		} else {
			return array_merge(
				[
					'status' => 'success',
				],
				[
					'data' => $this->data,
				]
			);
		}
	}

	public function build() {
		$response = new JsonResponse($this->toArray(), $this->getStatusCode());
		if ($this->hasErrors()) {
			$response->headers->set('Content-Type', 'application/problem+json');
		}

		return $response;
	}

	public function setData($name, $value) {
		$this->data[$name] = $value;
	}

	public function setErrors($name, $value) {
		$this->errors[$name] = $value;
	}

	public function hasErrors() {
		return !empty($this->errors);
	}

	public function getStatusCode() {
		return $this->statusCode;
	}
}
