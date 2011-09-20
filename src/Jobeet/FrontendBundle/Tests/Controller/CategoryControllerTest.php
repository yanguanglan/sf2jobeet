<?php
/**
 * 1 test, 3 assertions
 */

namespace Jobeet\FrontendBundle\Tests\Controller;

use Jobeet\FrontendBundle\Tests\ControllerTestCase;

class CategoryControllerTest extends ControllerTestCase
{
	public function testIndex()
	{
		// max n munka van list�zva
		$max = $this->container->getParameter('max_jobs_category');
		$crawler = $this->client->request('GET','/category/programming');
		$this->assertTrue($crawler->filter('.jobs tr')->count() <= $max);
		// van lapoz�
		$this->assertTrue($crawler->filter('div.pagination a')->count() > 0);
		// �s m�k�dik is
		$link = $crawler->selectLink('2')->link();
		$this->client->click($link);
		$request = $this->client->getRequest();
		$this->assertEquals($request->get('page'),2);
	}
	
}