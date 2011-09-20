<?php

namespace Jobeet\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/",name="home")
     * @Template()
     */
    public function indexAction()
    {
    	$catrepo = $this->getDoctrine()->getRepository('JobeetFrontendBundle:Category');
    	$jobrepo = $this->getDoctrine()->getRepository('JobeetFrontendBundle:Job');
		$categories = $catrepo->getWithActiveJobs();
        return array(
        	'categories'	=> $categories,
        	'catrepo'		=> $catrepo,
        	'max_jobs'		=> $this->container->getParameter('max_jobs'),
        	'jobrepo'		=> $jobrepo
        );
    }
    
    /**
     * @Template()
     */
    public function recentAction()
    {
    	$session = $this->getRequest()->getSession();
    	$recent_jobs = $session->get('recent_jobs');
    	if (is_array($recent_jobs))	$history = $this->getDoctrine()->getRepository('JobeetFrontendBundle:Job')->getJobHistory($recent_jobs);
    	else $history = array();
    	return array('history' => $history);
    }	
}