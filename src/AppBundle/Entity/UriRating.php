<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UriRating
 *
 * @ORM\Table(name="uri_rating")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UriRatingRepository")
 */
class UriRating {
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
	 * @Assert\Length(
	 *      min = 2,
	 *      max = 255,
	 * )
	 * @ORM\Column(name="visitorId", type="string", length=255)
	 */
	private $visitorId;

	/**
	 * @var int
	 *
	 * @Assert\Range(
	 *      min = 1,
	 *      max = 10,
	 * )
	 *
	 * @ORM\Column(name="rating", type="smallint")
	 */
	private $rating;

	/**
	 * @ORM\ManyToOne(targetEntity="Uri", inversedBy="ratings")
	 * @ORM\JoinColumn(name="uri_id", referencedColumnName="id")
	 */
	private $uri;

	/**
	 * Get id
	 *
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set visitorId
	 *
	 * @param string $visitorId
	 *
	 * @return UriRating
	 */
	public function setVisitorId($visitorId) {
		$this->visitorId = $visitorId;

		return $this;
	}

	/**
	 * Get visitorId
	 *
	 * @return string
	 */
	public function getVisitorId() {
		return $this->visitorId;
	}

	/**
	 * Set rating
	 *
	 * @param integer $rating
	 *
	 * @return UriRating
	 */
	public function setRating($rating) {
		$this->rating = $rating;

		return $this;
	}

	/**
	 * Get rating
	 *
	 * @return int
	 */
	public function getRating() {
		return $this->rating;
	}

	/**
	 * Set uri
	 *
	 * @param \AppBundle\Entity\Uri $uri
	 *
	 * @return UriRating
	 */
	public function setUri(\AppBundle\Entity\Uri $uri = null) {
		$this->uri = $uri;

		return $this;
	}

	/**
	 * Get uri
	 *
	 * @return \AppBundle\Entity\Uri
	 */
	public function getUri() {
		return $this->uri;
	}
}
