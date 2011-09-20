<?php
namespace Jobeet\BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class CategoryAdmin extends Admin
{
	public function configureShowFields(ShowMapper $showMapper)
	{
		$showMapper
			->add('name')
			->add('slug')
		;
	}
	
	public function configureFormFields(FormMapper $formMapper)  
	{  
		$formMapper
			->add('name')
			->add('slug')
		;  
	}
	
	public function configureListFields(ListMapper $listMapper)  
	{  
		$listMapper  
			->addIdentifier('id')
			->add('name')
		;
	}
	
}