<?php

namespace AppBundle\Service;

use AppBundle\Entity\Uri;
use Carbon\Carbon;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Validation;

class FindOrCreateUri
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var AppBundle\Servic\ParseUrl
     */
    private $parser;

    /**
     * @var array
     */
    private $errors;

    /**
     * @var array
     */
    private $uri;

    /**
     * Create a Job findOrCreateUri.
     *
     * @param Doctrine\ORM\EntityManager $em
     * @param AppBundle\Servic\ParseUrl  $parser
     */
    public function __construct(EntityManager $em, ParseUrl $parser)
    {
        $this->em = $em;
        $this->parser = $parser;
    }

    public function handle($uriString)
    {
        $repository = $this->em->getRepository('AppBundle:Uri');

        if (!$this->validate($uriString)) {
            return $this;
        }

        $parsedUrl = $this->parser->handle($uriString);

        $this->uri = $repository->findOneByUri($parsedUrl->getFormatedUrl());

        if (!$this->uri) {
            $this->createNewUri($parsedUrl->getFormatedUrl());
        }

        return $this;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function formatResponse()
    {
        return [
            'uri'   => $this->uri->getUri(),
            'score' => $this->uri->getScore(),
        ];
    }

    public function hasErrors()
    {
        return 0 !== count($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function validate($uriString)
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($uriString, [
            new NotBlank(),
            new Url(),
        ]);

        if (0 !== count($violations)) {
            foreach ($violations as $violation) {
                $this->errors[] = $violation->getMessage();
            }

            return false;
        }

        return true;
    }

    private function createNewUri($url)
    {
        $newUri = new Uri();
        $newUri->setUri($url);
        $newUri->setSumUsers(0);
        $newUri->setSumRating(0);
        $newUri->setScore(0);
        $newUri->setCreatedAt(Carbon::now());
        $newUri->setUpdatedAt(Carbon::now());
        $this->em->persist($newUri);
        $this->em->flush();

        return $this->uri = $newUri;
    }
}
