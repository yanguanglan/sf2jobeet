<?php

namespace Jobeet\BackendBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class AffiliateAdminController extends Controller
{
	public function activateAction($token)
	{
		$affiliate = $this->getDoctrine()->getRepository('JobeetFrontendBundle:Affiliate')->findOneByToken($token);
		$affiliate->setIsActive(true);
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($affiliate);
		$em->flush();
		
		// email
		$message = \Swift_Message::newInstance()
			->setSubject('Jobeet Affiliate')
			->setFrom('admin@sf2jobeet.hu')
			->setTo($affiliate->getEmail())
			->setContentType('text/html')
			->setCharset('utf-8')
			->setBody($this->render('JobeetBackendBundle:AffiliateAdmin:email.html.twig', array('token' => $affiliate->getToken())));
		$this->get('mailer')->send($message);
		
		$this->getRequest()->getSession()->setFlash('sonata_flash_success','The affiliate has been activated successfully');
		return $this->redirect($this->generateUrl('admin_jobeet_frontend_affiliate_list'));
	}
	
	public function disableAction($token)
	{
		$affiliate = $this->getDoctrine()->getRepository('JobeetFrontendBundle:Affiliate')->findOneByToken($token);
		$affiliate->setIsActive(false);
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($affiliate);
		$em->flush();
		
		$this->getRequest()->getSession()->setFlash('sonata_flash_success','The affiliate has been disabled successfully');
		return $this->redirect($this->generateUrl('admin_jobeet_frontend_affiliate_list'));
	}
}