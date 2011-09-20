<?php

namespace Jobeet\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jobeet\FrontendBundle\Entity\Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Jobeet\FrontendBundle\Entity\CategoryRepository")
 */
class Category
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     */
    private $slug;

    /**
     * @var Affiliate
     *
     * @ORM\ManyToMany(targetEntity="Affiliate", mappedBy="category")
     */
    private $affiliate;
    
    
    /**
     * @var Jobs
     *
     * @ORM\OneToMany(targetEntity="Job",mappedBy="category")
     * @ORM\JoinTable{name="job",
     *     	joinColumns(@JoinColoumn(name="id", referencedColumnName="category_id")),
     * )
     */
    private $jobs;

    public function __construct()
    {
        $this->affiliate = new \Doctrine\Common\Collections\ArrayCollection();
    }
    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add affiliate
     *
     * @param Jobeet\FrontendBundle\Entity\Affiliate $affiliate
     */
    public function addAffiliate(\Jobeet\FrontendBundle\Entity\Affiliate $affiliate)
    {
        $this->affiliate[] = $affiliate;
    }

    /**
     * Get affiliate
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAffiliate()
    {
        return $this->affiliate;
    }
    
    /**
     * Add job
     *
     * @param Jobeet\FrontendBundle\Entity\Job $job
     */
    public function addJob(\Jobeet\FrontendBundle\Entity\Job $job)
    {
        $this->jobs[] = $job;
    }

    /**
     * Get jobs
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getJobs()
    {
        return $this->jobs;
    }
    
    /**
     * Get active jobs
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getActiveJobs()
    {
    	// $em-ből EntityManagert kéne csinálni vhogy
        $q = $em->createQueryBuilder()
        	->from('Job','j')
        	->where('j.category = :cat')
	        ->setParameter('cat',$this);
	    $q = $em->getRepository('JobeetFrontendBundle:Job')->addActiveJobsQ($q);
	    return $q->getResult();
    }
    
    public function __toString()   
    {
    	return $this->getName();
    }
}