<?php
namespace Jobeet\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Jobeet\FrontendBundle\Entity\Job;
use Jobeet\FrontendBundle\Form\Type\JobType;

class JobController extends Controller
{
	/**
     * @Template()
     */
	public function showAction($company_slug, $location_slug, $id, $position_slug)
	{
		$job = $this->getDoctrine()->getRepository('JobeetFrontendBundle:Job')->findOneById($id);
		if ($job instanceof Job && $job->getIsActivated() && !$job->isExpired())
		{
			$session = $this->getRequest()->getSession();
			$recent_jobs = $session->get('recent_jobs');
			if (!$recent_jobs) $recent_jobs = array();
			if (!in_array($job->getId(),$recent_jobs))
			{
				array_unshift($recent_jobs,$job->getId());
				$session->set('recent_jobs',array_slice($recent_jobs,0,3));
			}
			
			return array('job' => $job);			
		}
		throw $this->createNotFoundException('There is no active job with the requested parameters.');
	}
	
	/**
	 * @Template()
	 */
	public function newAction()
	{
		$job = new Job();
		$request = $this->getRequest();
		$form = $this->createForm(new JobType(),$job);
			
		if ($request->getMethod() == 'POST')
		{
			$form->bindRequest($request);
			if ($form->isValid())
			{
				$em = $this->getDoctrine()->getEntityManager();
				$job = $form->getData();
				$job->setToken($this->getDoctrine()->getRepository('JobeetFrontendBundle:Job')->generateToken($job->getEmail()));
				$job->setCreatedAt(new \DateTime('now'));
				$job->setUpdatedAt($job->getCreatedAt());
				$job->setExpiresAt(new \DateTime(date('Y-m-d H:i:s',time() + 86400*30)));
				$em->persist($job);
				$em->flush();
				$request->getSession()->setFlash('notice','Your Job has been saved');
				return $this->redirect($this->generateUrl('job_manage',array(
						'token' => $job->getToken()
					)));
			}
		}
		
		return array('form' => $form->createView());
	}
	
	/**
	 * @Template()
	 */
	public function manageAction($token)
	{
		$job = $this->getDoctrine()->getRepository('JobeetFrontendBundle:Job')->findOneByToken($token);
		if ($job instanceof Job) return array( 'job' => $job );
		else throw $this->createNotFoundException('There is no job with the given token. You might have mistyped the url?');
	}
	
	/**
	 * @Template()
	 */
	public function editAction($token)
	{
		$job = $this->getDoctrine()->getRepository('JobeetFrontendBundle:Job')->findOneByToken($token);
		if ($job instanceof Job && !$job->getIsActivated())
		{
			$request = $this->getRequest();
			$form = $this->createForm(new JobType(),$job);
			if ($request->getMethod() == 'POST')
			{
				$form->bindRequest($request);
				if ($form->isValid())
				{
					$em = $this->getDoctrine()->getEntityManager();
					$em->persist($job);
					$em->flush();
					$request->getSession()->setFlash('notice','Your Job has been updated successfully');
					return $this->redirect($this->generateUrl('job_manage',array( 'token' => $job->getToken() )));
				}	
			}
			return array('job' => $job, 'form' => $form->createView());
		}
		else throw $this->createNotFoundException('There is no inactive job with the given token. You might have mistyped the url?');
	}
	
	public function publishAction($token)
	{
		$jobrepo = $this->getDoctrine()->getRepository('JobeetFrontendBundle:Job');
		$job = $jobrepo->findOneByToken($token);
		if ($job instanceof Job)
		{
			$job->setIsActivated(true);
			$job->setUpdatedAt(new \DateTime('now'));
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($job);
			$em->flush();
			$this->get('lucene')->indexData($job->asIndexArray());
			$this->getRequest()->getSession()->setFlash('notice','Your Job is now active for 30 days.');
			return $this->redirect($this->generateUrl('job_show', array(
					"company_slug"	=> $job->getSlug('company'),
					"position_slug"	=> $job->getSlug('position'),
					"location_slug"	=> $job->getSlug('location'),
					"id"			=> $job->getId()
				)));
		}
		else throw $this->createNotFoundException('There is no job with the given token. You might have mistyped the url?');
	}
	
	public function extendAction($token)
	{
		$job = $this->getDoctrine()->getRepository('JobeetFrontendBundle:Job')->findOneByToken($token);
		if ($job instanceof Job && $job->expiresSoon())
		{
			if ($job->extend(30))
			{
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($job);
				$em->flush();
				$this->get('lucene')->indexData($job->asIndexArray());
				$this->getRequest()->getSession()->setFlash('notice','The activity of the job with the given token has been extended for another 30 days successfully.');
				return $this->redirect($this->generateUrl('home'));	
			}
			else
			{
				$this->getRequest()->getSession()->setFlash('error','The activity of the job with the given token can not be extended, because it is already expired');
				return $this->redirect($this->generateUrl('home'));
			}
		}
		else throw $this->createNotFoundException('There is no extendable job with the given token. You might have mistyped the url?');
	}
	
	public function deleteAction($token)
	{
		$job = $this->getDoctrine()->getRepository('JobeetFrontendBundle:Job')->findOneByToken($token);
		if ($job instanceof Job)
		{
			$this->get('lucene')->removeData($job->getId());
			$em = $this->getDoctrine()->getEntityManager();
			$em->remove($job);
			$em->flush();
			$this->getRequest()->getSession()->setFlash('notice','The job with the given token has been deleted successfully.');
			return $this->redirect($this->generateUrl('home'));
		}
		else throw $this->createNotFoundException('There is no job with the given token. You might have mistyped the url?');
	}
	
	/**
	 * @Template()
	 */
	public function searchAction()
	{
		// Ez az utólagos indexelés miatt van itt, nem töröltem ki, hátha kell még
		/*$jobs = $this->getDoctrine()->getRepository('JobeetFrontendBundle:Job')->addActiveJobsQ()->getQuery()->getResult();
		$lucene = $this->get('lucene');
		foreach ($jobs as $job)
		{
			$lucene->indexData($job->asIndexArray());
		}*/
		$query = trim($this->getRequest()->query->get('query')).'*';
		$idx = $this->get('lucene')->findData($query);
		if (empty($idx))
		{
			$found = false;
			$jobs = null;
		}
		else
		{
			$found = true;
			$jobs = $this->getDoctrine()->getRepository('JobeetFrontendBundle:Job')->findJobsById($idx);
		}
		
		if ($this->getRequest()->isXmlHttpRequest())
		{
			if (!$found) return new Response('No results.');
			return $this->render('JobeetFrontendBundle:Job:list.html.twig',array('jobs' => $jobs));
		}
		
		return array('found' => $found, 'jobs' => $jobs);
	}
}