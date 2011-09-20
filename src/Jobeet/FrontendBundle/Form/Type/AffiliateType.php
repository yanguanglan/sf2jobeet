<?php
namespace Jobeet\FrontendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AffiliateType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder->add('email');
		$builder->add('url');
		$builder->add('category');
	}
	
	public function getName()
	{
		return 'Affiliate';
	}
}