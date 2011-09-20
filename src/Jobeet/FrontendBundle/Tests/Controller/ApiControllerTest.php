<?php
/**
 * 1 test, 10 assertions
 */

namespace Jobeet\FrontendBundle\Tests\Controller;

use Jobeet\FrontendBundle\Tests\ControllerTestCase;

class ApiControllerTest extends ControllerTestCase
{
	public function testList()
	{
		//$this->reloadFixtures();
		// azonosító kell a használathoz
		$this->client->request('GET','/api/foo/jobs.xml');
		$this->assertTrue($this->client->getResponse()->isNotFound());
		
		// inaktív partner nem éri el
		$this->client->request('GET','/api/symfony/jobs.xml');
		$this->assertTrue($this->client->getResponse()->isNotFound());
		
		// csak a kért munkákat adja (1 design, 32 programming)
		$crawler = $this->client->request('GET','/api/sensio_labs/jobs.xml');
		$this->assertEquals($crawler->filter('job')->count(),32);
		
		// van limit
		$crawler = $this->client->request('GET','/api/sensio_labs/5/jobs.xml');
		$this->assertEquals($crawler->filter('job')->count(),5);
		
		// egy kategóriára lehet szűkíteni (1 design)
		$crawler = $this->client->request('GET','/api/sensio_labs/design/jobs.xml');
		$this->assertEquals($crawler->filter('job')->count(),1);
		$this->assertEquals($crawler->filter('job category:contains("Design")')->count(),1);
		
		// egy kategórián belül is van limit
		$crawler = $this->client->request('GET','/api/sensio_labs/programming/5/jobs.xml');
		$this->assertEquals($crawler->filter('job')->count(),5);
		$this->assertEquals($crawler->filter('job category:contains("Programming")')->count(),5);
		
		// JSON
		$crawler = $this->client->request('GET','/api/sensio_labs/design/jobs.json');
		$this->assertTrue($this->client->getResponse()->headers->contains('Content-type','application/json'));
		$this->assertRegExp('/"category":"Design",/',$this->client->getResponse()->getContent());
		
		// YAML
		$crawler = $this->client->request('GET','/api/sensio_labs/design/jobs.yaml');
		$this->assertTrue($this->client->getResponse()->headers->contains('Content-type','text/yaml'));
		$this->assertRegExp('/category: "Design"/',$this->client->getResponse()->getContent());
	}
}