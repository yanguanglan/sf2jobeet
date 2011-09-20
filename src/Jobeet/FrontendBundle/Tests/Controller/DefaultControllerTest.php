<?php
/**
 * 1 test, 11 assertions
 */

namespace Jobeet\FrontendBundle\Tests\Controller;

use Jobeet\FrontendBundle\Tests\ControllerTestCase;

class DefaultControllerTest extends ControllerTestCase
{
	public function getHome()
	{
		return $this->client->request('GET','/');
	}
	
    public function testIndex()
    {
		$this->client->followRedirects();
        
        $crawler = $this->getHome();
		// Nincs lejárt munka a főoldalon
        $this->assertEquals($crawler->filter('.jobs td.position:contains("expired")')->count(),0);
        // Max n munka van listázva
        $max = $this->container->getParameter('max_jobs');
        $this->assertEquals($crawler->filter('.category_programming tr')->count(),$max);
        // Csak akkor van több munka link, ha kell
        $this->assertEquals($crawler->filter('.category_design .more_jobs')->count(),0);
        $this->assertEquals($crawler->filter('.category_programming .more_jobs')->count(),1);
        // Dátum szerint rendezve vanak
        $jobrepo = $this->container->get('doctrine')->getRepository('JobeetFrontendBundle:Job');
        $job = $jobrepo->getLatestProgrammingJob();
        $this->assertEquals($crawler->filter('.category_programming tr')->first()->filter('a[href*='.$job->getId().']')->count(),1);
        
        // A listázott munkák kattinthatóak
        $link = $crawler->selectLink('Web Developer')->link();
        $this->client->click($link);
        $request = $this->client->getRequest();
        $this->assertEquals($request->get('company_slug'),$job->getSlug('company'));
        $this->assertEquals($request->get('position_slug'),$job->getSlug('position'));
        $this->assertEquals($request->get('location_slug'),$job->getSlug('location'));
        $this->assertEquals($request->get('id'),$job->getId());
        
        // A kategóriák kattinthatóak
        $crawler = $this->getHome();
        $link = $crawler->selectLink('Programming')->link();
        $this->client->click($link);
        $request = $this->client->getRequest();
        $this->assertEquals($request->get('slug'),'programming');
        // A több munka link is kattintható
        $crawler = $this->getHome();
        $link = $crawler->filter('.more_jobs a')->link();
        $this->client->click($link);
        $request = $this->client->getRequest();
        $this->assertEquals($request->get('slug'),'programming');
    }
}
