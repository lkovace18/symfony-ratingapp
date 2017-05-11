<?php

namespace AppBundle\Service;

use AppBundle\Entity\Uri;
use Carbon\Carbon;
use Doctrine\ORM\EntityManager;

class FindOrCreateUri {

	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	private $em;

	/**
	 * @var AppBundle\Servic\ParseUrl
	 */
	private $parser;

	/**
	 * Create a Job findOrCreateUri.
	 *
	 * @param Doctrine\ORM\EntityManager $em
	 * @param AppBundle\Servic\ParseUrl $parser
	 */
	public function __construct(EntityManager $em, ParseUrl $parser) {
		$this->em = $em;
		$this->parser = $parser;
	}

	public function handle($uriString) {

		$repository = $this->em->getRepository('AppBundle:Uri');

		$parsedUrl = $this->parser->handle($uriString);
		if (!$parsedUrl) {
			return false;
		}

		$uri = $repository->findOneByUri($parsedUrl->getFullUrl());

		if ($uri) {
			return $uri;
		}

		return $this->createNewUri($parsedUrl->getFullUrl());
	}

	private function createNewUri($url) {
		$newUri = new Uri;
		$newUri->setUri($url);
		$newUri->setSumUsers(0);
		$newUri->setSumRating(0);
		$newUri->setScore(0);
		$newUri->setCreatedAt(Carbon::now());
		$newUri->setUpdatedAt(Carbon::now());
		$this->em->persist($newUri);
		$this->em->flush();

		return $newUri;
	}
}