<?php
namespace Jobeet\FrontendBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\DoctrineFixturesBundle\Common\DataFixtures\Loader as DataFixturesLoader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

class ControllerTestCase extends WebTestCase
{
	protected $client;
	protected $container;
	protected $_em;
	
	public function setUp()
	{
		$this->client = static::createClient();
		$this->container = $this->client->getContainer();
		$this->_em = $this->container->get('doctrine.orm.entity_manager');
	}
	
	/** 
     * A jobeet_test adatbázisban nincsenek kapcsolatok, hirtelen nem tudtam máshogy kikerülni az sql hibát
     */
	public function reloadFixtures()
	{
		$lucene = $this->container->get('lucene');
		$loader = new DataFixturesLoader($this->container);
		$loader->loadFromDirectory('src/Jobeet/FrontendBundle/DataFixtures/ORM');
		$fixtures = $loader->getFixtures();
		$purger = new ORMPurger($this->_em);
        $executor = new ORMExecutor($this->_em, $purger);
        $executor->execute($fixtures, false);
	}
}