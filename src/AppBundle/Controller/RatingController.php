<?php

namespace AppBundle\Controller;

use AppBundle\Api\ApiResponse;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("api")
 */
class RatingController extends FOSRestController {

	/**
	 * Get rating for uri
	 *
	 * @ApiDoc(
	 *  resource=true,
	 *  description="Get rating for uri",
	 *  requirements={
	 *      {
	 *          "name"="uri",
	 *          "dataType"="string",
	 *          "requirement"="true",
	 *          "description"="Uri of site"
	 *      }
	 *  },
	 *  statusCodes={
	 *    200="Returned on success",
	 *    400="Returned on faliure",
	 *  }
	 * )
	 *
	 * @Post("/rating", name="rating_site_votes")
	 */
	public function getUriRatingAction(Request $request) {
		$data = $request->request->get('data');

		$uri = $this->container
			->get('find_or_create_uri')
			->handle($data['uri']);

		if ($uri->hasErrors()) {
			$response = new ApiResponse(400);
			$response->setErrors($uri->getErrors());

			return $response->build();
		}

		return (new ApiResponse(
			200,
			$uri->formatResponse()
		))->build();
	}

	/**
	 * Vote for specific Uri.
	 *
	 * @ApiDoc(
	 *  resource=true,
	 *  description="Vote for specific Uri.",
	 *  requirements={
	 *    {
	 *        "name"="visitor_id",
	 *        "dataType"="string",
	 *        "requirement"="true",
	 *        "description"="Uri of site"
	 *    },
	 *    {
	 *        "name"="uri",
	 *        "dataType"="string",
	 *        "requirement"="true",
	 *        "description"="Uri of site"
	 *    },
	 *    {
	 *       "name"="rating",
	 *       "dataType"="integer",
	 *       "requirement"="true",
	 *       "description"="Rating for site can be in range  1-10"
	 *     }
	 *  },
	 *  statusCodes={
	 *    200="Returned on success",
	 *    400="Returned on faliure",
	 *  } *
	 * )
	 *
	 * @Post("/rating/vote", name="rating_vote")
	 */
	public function voteForUriAction(Request $request) {
		$data = $request->request->get('data');

		$vote = $this->container
			->get('vote_for_uri')
			->handle($data['uri'], $data['visitor_id'], $data['rating']);

		if ($vote->hasErrors()) {
			$response = new ApiResponse(400);
			$response->setErrors($vote->getErrors());

			return $response->build();
		}

		return (new ApiResponse(
			200,
			$vote->formatResponse()
		))->build();
	}

}
