<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LandingController extends Controller
{
    /**
     * @Route("/")
     */
    public function showIndexAction()
    {
        return $this->render('AppBundle:Landing:show_index.html.twig', [
            // ...
        ]);
    }
}
