<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LandingController extends Controller
{
    /**
     * @Route("/")
     */
    public function showIndexAction()
    {
        return $this->render('AppBundle:Landing:show_index.html.twig', array(
            // ...
        ));
    }

}
