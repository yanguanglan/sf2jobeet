<?php

namespace Jobeet\BackendBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class JobAdminController extends Controller
{
	public function extendAction($token)
	{
		$job = $this->getDoctrine()->getRepository('JobeetFrontendBundle:Job')->findOneByToken($token);
		$job->extend(30,true);
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($job);
		$em->flush();
		
		$this->getRequest()->getSession()->setFlash('sonata_flash_success','The activity of the job has been extended successfully');
		return $this->redirect($this->generateUrl('admin_jobeet_frontend_job_list'));
	}
}