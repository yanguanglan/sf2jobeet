<?php
namespace Jobeet\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CategoryController extends Controller
{
	/**
	 * @Template()
	 */
	public function indexAction($slug,$page)
	{
		$catrepo = $this->getDoctrine()->getRepository('JobeetFrontendBundle:Category');
		$category = $catrepo->findOneBySlug($slug);
		return array(
			'cat' => $category,
			'catrepo' => $catrepo,
			'max_jobs' => $this->container->getParameter('max_jobs_category'),
			'page' => $page
		);
	}
}