<?php

namespace Jobeet\FrontendBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface,
 Jobeet\FrontendBundle\Entity\Job,
 Jobeet\FrontendBundle\Entity\Category,
 Jobeet\FrontendBundle\Entity\Affiliate,
 Symfony\Component\DependencyInjection\ContainerAwareInterface,
 Symfony\Component\DependencyInjection\ContainerInterface;

class LoadJobeetData implements FixtureInterface, ContainerAwareInterface
{
	private $container;
	private $lucene;
	
	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
		$this->lucene = $this->container->get('lucene');
	}
	
    public function load($em)
    {
       // Category
       $design = new Category();
       $design->setName('Design');
       $design->setSlug('design');

       $programming = new Category();
       $programming->setName('Programming');
       $programming->setSlug('programming');
       
       $manager = new Category();
       $manager->setName('Manager');
       $manager->setSlug('manager');

       $administrator = new Category();
       $administrator->setName('Administrator');
       $administrator->setSlug('administrator');

       $em->persist($design);
       $em->persist($programming);
       $em->persist($manager);
       $em->persist($administrator);
	   
       // Job
       $sensio = new Job();
       $sensio->setCategory($design);
       $sensio->setType('full-time');
       $sensio->setCompany('Sensio Labs');
       $sensio->setLogo('sensio-labs.gif');
       $sensio->setUrl('http://www.sensiolabs.com/');
       $sensio->setPosition('Web Designer');
       $sensio->setLocation('Paris, France');
       $sensio->setDescription("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.
		    
		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");
       $sensio->setHowToApply('Send your resume to fabien.potencier [at] sensio.com');
       $sensio->setIsPublic(true);
       $sensio->setIsActivated(true);
       $sensio->setToken('job_sensio_labs');
       $sensio->setEmail('job@example.com');
       $sensio->setExpiresAt(new \DateTime('2012-10-10'));

       $expired = new Job();
       $expired->setCategory($design);
       $expired->setType('part-time');
       $expired->setCompany('Extreme Sensio');
       $expired->setLogo('extreme-sensio.gif');
       $expired->setUrl('http://www.extreme-sensio.com/');
       $expired->setPosition('expired');
       $expired->setLocation('Paris, France');
       $expired->setDescription("You've already developed websites with symfony and you want to work with Open-Source technologies. You have a minimum of 3 years experience in web development with PHP or Java and you wish to participate to development of Web 2.0 sites using the best frameworks available.");
       $expired->setHowToApply('Send your resume to fabien.potencier [at] sensio.com');
       $expired->setIsPublic(true);
       $expired->setIsActivated(true);
       $expired->setToken('expired_job');
       $expired->setEmail('job@example.com');
       $expired->setExpiresAt(new \DateTime('2010-10-10'));

       $em->persist($sensio);
       $em->persist($expired);
       $this->lucene->indexData($sensio->asIndexArray());
	   
       $jobs = array();
       for ($i = 100; $i < 131; $i++)
       {
       		$job = new Job();
       		$job->setCategory($programming);
		    $job->setType('part-time');
		    $job->setCompany('Company_'.$i);
		    $job->setUrl('http://www.extreme-sensio.com/');
		    $job->setPosition('Web Developer');
		    $job->setLocation('Paris, France');
		    $job->setDescription("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.
		    
		    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");
		    $job->setHowToApply('Send your resume to fabien.potencier [at] sensio.com');
		    $job->setIsPublic(true);
		    $job->setIsActivated(true);
		    $job->setToken('job_'.$i);
		    $job->setEmail('job@example.com');
		    $job->setExpiresAt(new \DateTime('2011-12-10'));
		    $em->persist($job);
		    $this->lucene->indexData($job->asIndexArray());
       }
       
        $job = new Job();
   		$job->setCategory($design);
	    $job->setType('part-time');
	    $job->setCompany('Expires');
	    $job->setUrl('http://www.fictional.com/');
	    $job->setPosition('Designer');
	    $job->setLocation('Tomorrow');
	    $job->setDescription("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in.
	    
	    Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");
	    $job->setHowToApply('Send your resume to fabien.potencier [at] sensio.com');
	    $job->setIsPublic(true);
	    $job->setIsActivated(true);
	    $job->setToken('job_extendable');
	    $job->setEmail('job@example.com');
	    $job->setExpiresAt(new \DateTime(date('Y-m-d',time() + 86400)));
	    $em->persist($job);
	    $this->lucene->indexData($job->asIndexArray());
       
       // Affiliate
       $sensio = new Affiliate();
       $sensio->setUrl("http://www.sensio-labs.com/");
       $sensio->setEmail("fabien.potencier@example.com");
       $sensio->setIsActive(true);
       $sensio->setToken("sensio_labs");
       $sensio->addCategory($design);
       $sensio->addCategory($programming);
       
       $symfony = new Affiliate();
       $symfony->setUrl("http://www.symfony-project.org/");
       $symfony->setEmail("example@example.com");
       $symfony->setIsActive(false);
       $symfony->setToken("symfony");
       $symfony->addCategory($design);
       $symfony->addCategory($programming);
       
       $em->persist($sensio);
       $em->persist($symfony);
       
       $em->flush();
    }
}