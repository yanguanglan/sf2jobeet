<?php
namespace Jobeet\FrontendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class JobType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder->add('category');
		$builder->add('type','choice',array(
				'choices'	=> array( 'full-time' => 'Full time', 'part-time' => 'Part time', 'freelance' => 'Freelance' ),
				'expanded'	=> true,
				'multiple'	=> false
			));
		$builder->add('company','text');
		$builder->add('logo','file',array('required' => false));
		$builder->add('url','url',array('required' => false));
		$builder->add('position','text');
		$builder->add('location','text');
		$builder->add('description','textarea');
		$builder->add('howToApply','textarea',array('label' => 'How to apply?'));
		$builder->add('isPublic','checkbox',array('label' => 'Public?','required' => false));
		$builder->add('email','email');
	}
	
	public function getName()
	{
		return 'Job';
	}
}