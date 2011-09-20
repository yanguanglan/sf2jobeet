<?php
/**
 * 1 test, 8 assertions
 */
use Jobeet\FrontendBundle\JobeetFrontendBundle;

class JobeetFrontendBundleTest extends PHPUnit_Framework_TestCase
{
	public function testSlugify()
	{
		$this->assertEquals(JobeetFrontendBundle::slugify('SenSio'),'sensio');
		$this->assertEquals(JobeetFrontendBundle::slugify('sensio labs'),'sensio-labs');
		$this->assertEquals(JobeetFrontendBundle::slugify('sensio   labs'),'sensio-labs');
		$this->assertEquals(JobeetFrontendBundle::slugify('paris,france'),'paris-france');
		$this->assertEquals(JobeetFrontendBundle::slugify('  sensio   '),'sensio');
		$this->assertEquals(JobeetFrontendBundle::slugify('áéíóöőúüű'),'aeiooouuu');
		$this->assertEquals(JobeetFrontendBundle::slugify(''),'n-a');
		$this->assertEquals(JobeetFrontendBundle::slugify(' - '),'n-a');
	}
}