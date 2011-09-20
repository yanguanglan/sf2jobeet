<?php
namespace Jobeet\BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class JobAdmin extends Admin
{
	public function configureRoutes(RouteCollection $collection)
	{
		$collection->add('extend', '{token}/extend');
	}
	
	public function configureShowFields(ShowMapper $showMapper)
	{
		$showMapper
			->add('category')
			->add('company')
			->add('position')
			->add('location')
			->add('description')
			->add('url')
			->add('email')
			->add('howToApply')
			->add('isActivated')
			->add('isPublic')
		;
	}
	
	public function configureFormFields(FormMapper $formMapper)  
	{  
		$formMapper
			->add('company')
			->add('logo')
			->add('position')
			->add('type')
			->add('location')
			->add('description')
			->add('url')
			->add('email')
			->add('howToApply')
			->add('isActivated')
			->add('isPublic')
			->add('category')
			->add('expiresAt')
		;  
	}  
	
	public function configureListFields(ListMapper $listMapper)  
	{  
		$listMapper  
			->add('company') 
			->addIdentifier('position')
			->add('location')
			->add('slimUrl','string',array('name' => 'url'))
			->add('isActivated')
			->add('email')
			->add('category')
			->add('expiresAt')
			->add('_action','actions',array(
				'name' => 'actions',
				'actions' => array(
					'edit'   => array(),
					'delete' => array(),
					'extend' => array('template' => 'JobeetBackendBundle:JobAdmin:extend.html.twig')
				)
			))
		;
	}
   /*
	public function configureDatagridFilters(DatagridMapper $datagridMapper)  
	{  
		$datagridMapper
			->add('category')
			->add('company')
			->add('position')  
			->add('description')
			->add('isActivated')
			->add('isPublic')
			->add('email')
		;
	} */
	
    protected $maxPerPage = 5;
}