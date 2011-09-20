<?php
namespace Jobeet\BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class AffiliateAdmin extends Admin
{
	public function configureRoutes(RouteCollection $collection)
	{
		$collection->add('activate', '{token}/activate');
		$collection->add('disable', '{token}/disable');
	}
	
	public function configureShowFields(ShowMapper $showMapper)
	{
		$showMapper
			->add('email')
			->add('url')
			->add('category')
			->add('token')
			->add('isActive')
		;
	}
	
	public function configureFormFields(FormMapper $formMapper)  
	{  
		$formMapper
			->add('email')
			->add('url')
			->add('category')
			->add('token')
			->add('isActive')
		;  
	}
	
	public function configureListFields(ListMapper $listMapper)  
	{  
		$listMapper  
			->add('email')
			->add('url')
			->add('category')
			->add('token')
			->add('isActive')
			->add('_action',null,array('actions' => array(
					'edit'     => array(),
					'delete'   => array(),
					'activate' => array('template' => 'JobeetBackendBundle:AffiliateAdmin:activate.html.twig')
				)))
		;
	}
	
}