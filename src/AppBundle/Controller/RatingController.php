<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RatingController extends Controller {

	/**
	 * @Route("/rating/votes", name="rating_votes")
	 */
	public function listAction(Request $request) {
		//
	}

	/**
	 * @Route("/rating/votes", name="rating_vote")
	 */
	public function voteAction(Request $request) {
		//
	}

}
