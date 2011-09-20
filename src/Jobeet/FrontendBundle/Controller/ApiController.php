<?php
namespace Jobeet\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Jobeet\FrontendBundle\Entity\Affiliate;

class ApiController extends Controller
{
	/**
	 * @Template()
	 */
	public function listAction($token, $category = false, $limit = false)
	{
		$aff = $this->getDoctrine()->getRepository('JobeetFrontendBundle:Affiliate')->findOneByToken($token);
		if ($aff instanceof Affiliate && $aff->getIsActive())
		{
			$category = ( $category ? array($category) : $aff->getCategoryAsArray() );
			$job_objects = $this->getDoctrine()->getRepository('JobeetFrontendBundle:Job')->getActiveJobsForApi($category,$limit);
			$jobs = array();
			foreach ($job_objects as $job)
			{
				$url = $this->generateUrl(
					'job_show', array(
						'id'			=> $job->getId(),
						'company_slug'  => $job->getSlug('company'),
						'position_slug' => $job->getSlug('position'),
						'location_slug' => $job->getSlug('location')	
					),
					true
				);
				$jobs[$url] = $job->asArray();
			}
			return array('jobs' => $jobs);
		}
		throw $this->createNotFoundException('There is no active affiliate with the given token.');
	}
}