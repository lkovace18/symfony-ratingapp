<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;

class RatingController extends FOSRestController {

	/**
	 * GET Specific Uri Rating
	 *
	 * @ApiDoc(
	 *  resource=true,
	 *  description="Specific Uri Rating",
	 *  requirements={
	 *      {
	 *          "name"="uri",
	 *          "dataType"="string",
	 *          "requirement"="",
	 *          "description"="Uri of site"
	 *      }
	 *  },
	 *  statusCodes={
	 *    200="Returned when successful",
	 *  }
	 * )
	 *
	 * @Get("/rating/votes", name="rating_list_votes")
	 */
	public function getUriRatingAction(Request $request) {
		//
	}

	/**
	 * POST Vote for specific Uri.
	 *
	 * @ApiDoc(
	 *  resource=true,
	 *  description="Vote for specific Uri.",
	 *  requirements={
	 *    {
	 *        "name"="visitor_id",
	 *        "dataType"="string",
	 *        "requirement"="",
	 *        "description"="Uri of site"
	 *    },
	 *    {
	 *        "name"="uri",
	 *        "dataType"="string",
	 *        "requirement"="",
	 *        "description"="Uri of site"
	 *    },
	 *    {
	 *       "name"="rating",
	 *       "dataType"="integer",
	 *       "requirement"="",
	 *       "description"="Rateing for site can be 1-10"
	 *     }
	 *  },
	 *  statusCodes={
	 *    200="Returned when successful",
	 *  } *
	 * )
	 *
	 * @Post("/rating/votes", name="rating_vote")
	 */
	public function voteForUriAction(Request $request) {
		//
	}

}
