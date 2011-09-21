<?php
/**
 * 4 tests, 29 assertions
 *
 * @testNew    -  6 assertions
 * @testManage - 20 assertions
 * @testShow   -  2 assertions
 * @testSearch -  1 assertion
 */

namespace Jobeet\FrontendBundle\Tests\Controller;

use Jobeet\FrontendBundle\Tests\ControllerTestCase;

class JobControllerTest extends ControllerTestCase
{
	protected $jobrepo;
	
	public function setUp()
	{
		parent::setUp();
		$this->jobrepo = $this->container->get('doctrine')->getRepository('JobeetFrontendBundle:Job');
	}
	
	public function testNew()
	{
		$this->client->followRedirects();
		$crawler = $this->client->request('GET','/job/new');
		$form = $crawler->selectButton('Preview your Job')->form();
		// Üresen submit
		$crawler = $this->client->submit($form);
		$request = $this->client->getRequest();
		// Ha hiba van, akkor a controller: newAction, mert nem irányít át
		$this->assertEquals(
			$request->get('_controller'),
			'Jobeet\FrontendBundle\Controller\JobController::newAction'
		);
		/**
		 * A hibák ul-ben vannak az inputok elõtt/fölött,
		 * üres form esetén összesen 7.
		 * type, company, position, location, description, howToApply, email
		 * Mindegyik "This value should not be blank"
		 */
		$this->assertEquals(
			$crawler->filter('td ul li:contains("This value should not be blank")')->count(),
			7
		);
		$form['Job[url]'] = 'asdfas';
		$form['Job[email]'] = 'asdfas';
		$crawler = $this->client->submit($form);
		// url invalid
		$this->assertEquals($crawler->filter('td ul li:contains("This value is not a valid URL")')->count(), 1);
		// elé rakta a http:// -t
		$this->assertEquals($crawler->filter('td input[value^=http]')->count(), 1);
		// email invalid
		$this->assertEquals($crawler->filter('td ul li:contains("This value is not a valid email address")')->count(), 1);
		
		$form['Job[category]']->select(1);
		$form['Job[type]']->select('full-time');
		$form['Job[company]']     = 'ABC';
		$form['Job[url]']         = 'www.abc.com';
		$form['Job[position]']    = 'PHP Developer';
		$form['Job[location]']    = 'City, Country';
		$form['Job[description]'] = 'Lorem ipsum dolor sit amet';
		$form['Job[howToApply]']  = 'Send your resume to career[at]abc[dot]com';
		$form['Job[isPublic]']->tick();
		$form['Job[email]']       = 'career@abc.com';
		$crawler = $this->client->submit($form);
		$request = $this->client->getRequest();
		// Hiba nélkül rögzül, a controller:manageAction
		$this->assertEquals(
			$request->get('_controller'),
			'Jobeet\FrontendBundle\Controller\JobController::manageAction'
		);
		$this->reloadFixtures();
		$this->client->restart();
	}
	
	public function testManage()
	{
		$this->client->followRedirects();
		$crawler = $this->client->request('GET','/job/new');
		$form = $crawler->selectButton('Preview your Job')->form();
		$form['Job[category]']->select(1);
		$form['Job[type]']->select('full-time');
		$form['Job[company]']     = 'ABC';
		$form['Job[url]']         = 'www.abc.com';
		$form['Job[position]']    = 'PHP Developer';
		$form['Job[location]']    = 'City, Country';
		$form['Job[description]'] = 'Lorem ipsum dolor sit amet';
		$form['Job[howToApply]']  = 'Send your resume to career[at]abc[dot]com';
		$form['Job[isPublic]']->tick();
		$form['Job[email]']       = 'career@abc.com';
		$crawler = $this->client->submit($form);
		// Van admin bar
		$this->assertEquals($crawler->filter('div#job_actions h3:contains("Admin")')->count(), 1);
		// Benne edit, publish, delete, bookmark, nincs extend
		$this->assertEquals(
			$crawler->filter('div#job_actions ul li a[href$=edit]')->count(),
			1
		);
		$this->assertEquals(
			$crawler->filter('div#job_actions ul li a[href$=publish]')->count(),
			1
		);
		$this->assertEquals(
			$crawler->filter('div#job_actions ul li a[href$=delete]')->count(),
			1
		);
		$this->assertEquals(
			$crawler->filter('div#job_actions ul li:contains("Bookmark")')->count(),
			1
		);
		$this->assertEquals(
			$crawler->filter('div#job_actions ul li a[href$=extend]')->count(),
			0
		);
		
		$urlToManage = $crawler->filter('div#job_actions ul li:contains("Bookmark") a')->attr('href');
		
		// Publish -> JobeetFrontendBundle:Job:show, flash-notice
		$link = $crawler->selectLink('Publish')->link();
		$crawler = $this->client->click($link);
		$request = $this->client->getRequest();
		$this->assertEquals(
			$request->get('_controller'),
			'Jobeet\FrontendBundle\Controller\JobController::showAction'
		);
		$this->assertEquals($crawler->filter('.flash-notice:contains("Your Job is now active")')->count(), 1);
		
		// manage, nincs edit, publish
		$crawler = $this->client->request('GET',$urlToManage);
		$this->assertEquals(
			$crawler->filter('div#job_actions ul li a[href$=edit]')->count(),
			0
		);
		$this->assertEquals(
			$crawler->filter('div#job_actions ul li a[href$=publish]')->count(),
			0
		);
		
		// Ha szerkeszteni akarjuk 404
		$this->client->request('GET',$urlToManage.'/edit');
		$this->assertTrue($this->client->getResponse()->isNotFound());
		
		// Nem lehet hosszabbítani, ha még sokára jár le
		$this->client->request('GET',$urlToManage.'/extend');
		$this->assertTrue($this->client->getResponse()->isNotFound());
		
		// Delete van, és mûködik -> home, flash-notice:deleted successfully, megpróbálom megnézni -> 404
		$this->assertEquals(
			$crawler->filter('div#job_actions ul li a[href$=delete]')->count(),
			1
		);		
		
		$link = $crawler->selectLink('Delete')->link();
		$crawler = $this->client->click($link);
		$request = $this->client->getRequest();
		$this->assertEquals(
			$request->get('_controller'),
			'Jobeet\FrontendBundle\Controller\DefaultController::indexAction'
		);
		$this->assertEquals(
			$crawler->filter('.flash-notice:contains("The job with the given token has been deleted successfully")')
				->count(),
			1
		);
		
		$this->client->request('GET',$urlToManage);
		$this->assertTrue($this->client->getResponse()->isNotFound());
		
		// Meg lehet hosszabbítani, ha nemsokára lejár, job_extendable egy napon belül jár le
		$job = $this->jobrepo->findOneByToken('job_extendable');
		$this->assertTrue($job->getExpiresAt()->format('U') - time() < 86401);
		$crawler = $this->client->request('GET','/job/job_extendable');
		$extend = $crawler->selectLink('Extend for another 30 days')->link();
		$this->client->click($extend);
		$job = $this->jobrepo->findOneByToken('job_extendable');
		$this->assertTrue($job->getExpiresAt()->format('U') - time() < 86400*30 + 1);
		
		// reset
		$this->reloadFixtures();
		$this->client->restart();
		
		// A megtekintett munkák hozzáadódnak a recent listához
		$job = $this->jobrepo->findOneByPosition('Web Developer');
		$url = sprintf(
			'/job/%s/%s/%d/%s',
			$job->getSlug('company'),
			$job->getSlug('location'),
			$job->getId(),
			$job->getSlug('position')
		);
		$crawler = $this->client->request('GET',$url);
		$this->assertEquals(
			$crawler->filter(sprintf('div#job_history a[href*=%d]',$job->getId()))->count(),
			1
		);
		// És csak egyszer adódik hozzá
		$crawler = $this->client->request('GET',$url);
		$this->assertEquals(
			$crawler->filter(sprintf('div#job_history a[href*=%d]',$job->getId()))->count(),
			1
		);		
	}
	
	public function testShow()
	{
		// A nem létezõ munka 404-es
		$this->client->request('GET','/job/xxx/xxx/0/xxx');
		$this->assertTrue($this->client->getResponse()->isNotFound());
		// A lejárt munka is 404-es
		$expired_job = $this->jobrepo->getExpiredJob();
		$this->client->request('GET','/job/xxx/yyy/'.$expired_job->getId().'/zzz');
		$this->assertTrue($this->client->getResponse()->isNotFound());
	}
	
	public function testSearch()
	{
		// Keresõ
		$crawler = $this->client->request(
			'GET',
			'/job/search?query=sens'
		);
		$this->assertEquals($crawler->filter('table tr')->count(),1);
	}
}