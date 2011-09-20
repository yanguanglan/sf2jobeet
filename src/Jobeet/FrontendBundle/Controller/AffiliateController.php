<?php
namespace Jobeet\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Jobeet\FrontendBundle\Entity\Affiliate;
use Jobeet\FrontendBundle\Entity\CategoryAffiliate;
use Jobeet\FrontendBundle\Form\Type\AffiliateType;

class AffiliateController extends Controller
{
	/**
	 * @Template()
	 */
	public function newAction()
	{
		$affiliate = new Affiliate();
		$form = $this->createForm(new AffiliateType,$affiliate);
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST')
		{
			$form->bindRequest($request);
			if ($form->isValid())
			{
				$affiliate = $form->getData();
				$affiliate->setToken(
					$this->getDoctrine()->getRepository('JobeetFrontendBundle:Affiliate')->generateToken($affiliate->getEmail())
				);
				$affiliate->setIsActive(false);
				$affiliate->setCreatedAt(new \DateTime('now'));
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($affiliate);
				$em->flush();
				
				return $this->render('JobeetFrontendBundle:Affiliate:wait.html.twig');
			}
		}
		return array( 'form' => $form->createView() );
	}
}