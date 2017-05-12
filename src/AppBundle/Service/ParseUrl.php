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
	private $formatedUrl;

	/**
	 * @param array
	 */
	private $urlComponents;

	public function handle($urlString) {
		$this->urlComponents = parse_url($urlString);

		$this->domain = str_replace('www.', '', $this->urlComponents['host']);
		$this->buildFormatedUrl();

		return $this;
	}

	private function buildFormatedUrl() {
		$urlBuilder = $this->domain;

		if (isset($this->urlComponents['path'])) {
			$urlBuilder .= $this->urlComponents['path'];
		}

		if (isset($this->urlComponents['query'])) {
			$urlBuilder .= $this->urlComponents['query'];
		}

		$this->formatedUrl = $urlBuilder;
	}

	public function getDomain() {
		return $this->domain;
	}

	public function getFormatedUrl() {
		return $this->formatedUrl;
	}
}
