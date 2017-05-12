<?php

namespace Tests\AppBundle\Service;

use AppBundle\Service\ParseUrl;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class ParseUrlTest extends WebTestCase {

	/** @test */
	function it_parses_url_in_standard_format() {
		$parser = new ParseUrl;

		$parser->handle('https://www.example.com/some-cool/blog-post');

		$this->assertEquals(
			'example.com/some-cool/blog-post',
			$parser->getFormatedUrl()
		);

		$httpParser = new ParseUrl;
		$httpParser->handle('http://www.example.com/other-cool/blog-post');

		$httpsParser = new ParseUrl;
		$httpsParser->handle('https://www.example.com/other-cool/blog-post');

		$this->assertEquals(
			$httpParser->getFormatedUrl(),
			$httpsParser->getFormatedUrl()
		);

		$wwwParser = new ParseUrl;
		$wwwParser->handle('http://www.example.com/some-cool/app');

		$noWwwParser = new ParseUrl;
		$noWwwParser->handle('http://example.com/some-cool/app');

		$this->assertEquals(
			$wwwParser->getFormatedUrl(),
			$noWwwParser->getFormatedUrl()
		);

		$parser = new ParseUrl;

		$parser->handle('http://example.com/index');

		$this->assertEquals(
			'example.com/index',
			$parser->getFormatedUrl()
		);

	}

	/** @test */
	function it_parses_domain_from_url() {
		$parser = new ParseUrl;

		$parser->handle('https://www.example.com/some-cool/blog-post');

		$this->assertEquals(
			'example.com',
			$parser->getDomain()
		);
	}

}