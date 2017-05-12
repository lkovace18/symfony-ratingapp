<?php

namespace AppBundle\Service;

use AppBundle\Entity\UriRating;
use Carbon\Carbon;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Validation;

class VoteForUri
{
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
     * @var array
     */
    private $errors = [];

    /**
     * Create a Job VoteForUri.
     *
     * @param Doctrine\ORM\EntityManager       $em
     * @param AppBundle\Servic\FindOrCreateUri $uri
     */
    public function __construct(EntityManager $em, FindOrCreateUri $uriProvider)
    {
        $this->em = $em;
        $this->uriProvider = $uriProvider;
    }

    public function handle($uriString, $visitorId, $rating)
    {
        $this->validate($uriString, $visitorId, $rating);

        if ($this->hasErrors()) {
            return $this;
        }

        $this->uri = $this->uriProvider->handle($uriString)->getUri();
        $this->vote = $this->createNewUriVote($this->uri, $visitorId, $rating);

        $this->calculateNewUriScore();

        return $this;
    }

    public function hasErrors()
    {
        return 0 !== count($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function validate($uriString, $visitorId, $rating)
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($uriString, [
            new NotBlank(),
            new Url(),
        ]);

        if (0 !== count($violations)) {
            foreach ($violations as $violation) {
                $this->errors['uri'] = $violation->getMessage();
            }
        }

        $validator = Validation::createValidator();
        $violations = $validator->validate($visitorId, [
            new NotBlank(),
            new Length(['min' => 2, 'max' => 250]),
        ]);

        if (0 !== count($violations)) {
            foreach ($violations as $violation) {
                $this->errors['visitor-id'] = $violation->getMessage();
            }
        }

        $validator = Validation::createValidator();
        $violations = $validator->validate($rating, [
            new NotBlank(),
            new Range(['min' => 1, 'max' => 10]),
        ]);

        if (0 !== count($violations)) {
            foreach ($violations as $violation) {
                $this->errors['rating'] = $violation->getMessage();
            }
        }
    }

    public function calculateNewUriScore()
    {
        $this->uri->setSumUsers($this->uri->getSumUsers() + 1);
        $this->uri->setSumRating($this->uri->getSumRating() + $this->vote->getRating());
        $this->uri->setScore($this->uri->getSumRating() / $this->uri->getSumUsers());
        $this->em->flush();
    }

    public function formatResponse()
    {
        return [
            'uri'    => $this->uri->getUri(),
            'rating' => $this->vote->getRating(),
            'score'  => $this->uri->getScore(),
        ];
    }

    private function createNewUriVote($uri, $visitorId, $rating)
    {
        $newUriRating = new UriRating();
        $newUriRating->setUri($uri);
        $newUriRating->setRating($rating);
        $newUriRating->setVisitorId($visitorId);
        $newUriRating->setCreatedAt(Carbon::now());
        $newUriRating->setUpdatedAt(Carbon::now());
        $this->em->persist($newUriRating);
        $this->em->flush();

        return $newUriRating;
    }
}
