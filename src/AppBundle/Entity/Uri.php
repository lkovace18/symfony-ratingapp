<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Uri
 *
 * @ORM\Table(name="uri")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UriRepository")
 */
class Uri {
	/**
	 * Hook timestampable behavior
	 * updates createdAt, updatedAt fields
	 */
	use TimestampableEntity;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="guid")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="UUID")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="uri", type="string", length=255, unique=true)
	 */
	private $uri;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="sum_users", type="integer")
	 */
	private $sumUsers;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="sum_rating", type="integer")
	 */
	private $sumRating;

	/**
	 * @var decimal
	 *
	 * @ORM\Column(name="score", type="decimal", precision=5, scale=2)
	 */
	private $score;

	/**
	 * @ORM\OneToMany(targetEntity="UriRating", mappedBy="uri")
	 */
	private $ratings;

	/**
	 * Get id
	 *
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set uri
	 *
	 * @param string $uri
	 *
	 * @return Uri
	 */
	public function setUri($uri) {
		$this->uri = $uri;

		return $this;
	}

	/**
	 * Get uri
	 *
	 * @return string
	 */
	public function getUri() {
		return $this->uri;
	}

	/**
	 * Set sumUsers
	 *
	 * @param integer $sumUsers
	 *
	 * @return Uri
	 */
	public function setSumUsers($sumUsers) {
		$this->sumUsers = $sumUsers;

		return $this;
	}

	/**
	 * Get sumUsers
	 *
	 * @return int
	 */
	public function getSumUsers() {
		return $this->sumUsers;
	}

	/**
	 * Set sumRating
	 *
	 * @param integer $sumRating
	 *
	 * @return Uri
	 */
	public function setSumRating($sumRating) {
		$this->sumRating = $sumRating;

		return $this;
	}

	/**
	 * Get sumRating
	 *
	 * @return int
	 */
	public function getSumRating() {
		return $this->sumRating;
	}
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->ratings = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Add rating
	 *
	 * @param \AppBundle\Entity\UriRating $rating
	 *
	 * @return Uri
	 */
	public function addRating(\AppBundle\Entity\UriRating $rating) {
		$this->ratings[] = $rating;

		return $this;
	}

	/**
	 * Remove rating
	 *
	 * @param \AppBundle\Entity\UriRating $rating
	 */
	public function removeRating(\AppBundle\Entity\UriRating $rating) {
		$this->ratings->removeElement($rating);
	}

	/**
	 * Get ratings
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getRatings() {
		return $this->ratings;
	}

	/**
	 * Set score
	 *
	 * @param string $score
	 *
	 * @return Uri
	 */
	public function setScore($score) {
		$this->score = $score;

		return $this;
	}

	/**
	 * Get score
	 *
	 * @return string
	 */
	public function getScore() {
		return $this->score;
	}
}
