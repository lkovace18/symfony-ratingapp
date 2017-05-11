<?php

namespace AppBundle\Service;

use AppBundle\Entity\UriRating;
use Carbon\Carbon;
use Doctrine\ORM\EntityManager;

class VoteForUri {

	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	private $em;

	/**
	 * @var AppBundle\Servic\FindOrCreateUri
	 */
	private $uriProvider;

	/**
	 * @var AppBundle\Entity\UriRating
	 */
	private $vote;

	/**
	 * @var AppBundle\Entity\Uri
	 */
	private $uri;

	/**
	 * Create a Job VoteForUri
	 *
	 * @param Doctrine\ORM\EntityManager $em
	 * @param AppBundle\Servic\FindOrCreateUri $uri
	 */
	public function __construct(EntityManager $em, FindOrCreateUri $uriProvider) {
		$this->em = $em;
		$this->uriProvider = $uriProvider;
	}

	public function handle($uriString, $visitorId, $rating) {
		$this->uri = $this->uriProvider->handle($uriString);
		$this->vote = $this->createNewUriVote($this->uri, $visitorId, $rating);

		$this->calculateNewUriScore();

		return $this;
	}

	public function calculateNewUriScore() {
		$this->uri->setSumUsers($this->uri->getSumUsers() + 1);
		$this->uri->setSumRating($this->uri->getSumRating() + $this->vote->getRating());
		$this->uri->setScore($this->uri->getSumRating() / $this->uri->getSumUsers());
		$this->em->flush();
	}

	public function formatResponse() {
		return array(
			'uri' => $this->uri->getUri(),
			'rating' => $this->vote->getRating(),
			'score' => $this->uri->getScore(),
		);
	}

	private function createNewUriVote($uri, $visitorId, $rating) {
		$newUri = new UriRating;
		$newUri->setUri($uri);
		$newUri->setRating($rating);
		$newUri->setVisitorId($visitorId);
		$newUri->setCreatedAt(Carbon::now());
		$newUri->setUpdatedAt(Carbon::now());
		$this->em->persist($newUri);
		$this->em->flush();

		return $newUri;
	}
}