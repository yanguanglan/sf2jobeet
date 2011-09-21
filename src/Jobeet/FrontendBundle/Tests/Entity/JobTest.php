<?php
/**
 * 1 test, 3 assertions
 */
namespace Jobeet\FrontendBundle\Tests\Entity;

use Jobeet\FrontendBundle\Tests\EntityTestCase;
use Jobeet\FrontendBundle\Entity\Job;

class JobTest extends EntityTestCase
{
	public function testGetSlug()
	{
		$job = new Job();
		$job->setCompany('SenSio');
		$job->setLocation('Paris, France');
		$job->setPosition('Web Designer');
		$this->assertEquals($job->getSlug('company'),'sensio');
		$this->assertEquals($job->getSlug('location'),'paris-france');
		$this->assertEquals($job->getSlug('position'),'web-designer');
	}
}