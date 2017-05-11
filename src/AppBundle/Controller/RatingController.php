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
	 * POST Specific Uri Rating
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
	 * @Post("/rating", name="rating_site_votes")
	 */
	public function getUriRatingAction(Request $request) {

		$data = json_decode($request->request->get('data'));

		$uri = $this->container
			->get('find_or_create_uri')
			->handle($data->uri);

		$data = array(
			'uri' => $uri->getUri(),
			'score' => $uri->getScore(),
		);

		return (new ApiResponse(
			200,
			$data
		))->build();
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
	 * @Post("/rating/vote", name="rating_vote")
	 */
	public function voteForUriAction(Request $request) {
		$data = json_decode($request->request->get('data'));

		$vote = $this->container
			->get('vote_for_uri')
			->handle($data->uri, $data->visitor_id, $data->rating);

		return (new ApiResponse(
			200,
			$vote->formatResponse()
		))->build();
	}

}
