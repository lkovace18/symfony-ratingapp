<?php

namespace AppBundle\Service;

class ParseUrl {

	/**
	 * @param string
	 */
	private $domain;

	/**
	 * @param string
	 */
	private $fullUrl;

	/**
	 * @param array
	 */
	private $urlComponents;

	public function handle($uriString) {

		if (!$url = $this->validateUrl($uriString)) {
			return false;
		}

		$this->urlComponents = parse_url($url);

		$this->domain = str_replace('www.', '', $this->urlComponents['host']);
		$this->buildFullUrl();

		return $this;
	}

	private function validateUrl($url) {
		$url = filter_var($url, FILTER_SANITIZE_URL);
		if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
			return $url;
		}

		return false;

	}

	private function buildFullUrl() {
		$urlBuilder = $this->domain;

		if (isset($this->urlComponents['path'])) {
			$urlBuilder .= $this->urlComponents['path'];
		}

		if (isset($this->urlComponents['query'])) {
			$urlBuilder .= $this->urlComponents['query'];
		}

		$this->fullUrl = $urlBuilder;
	}

	public function getDomain() {
		return $this->domain;
	}

	public function getFullUrl() {
		return $this->fullUrl;
	}
}
