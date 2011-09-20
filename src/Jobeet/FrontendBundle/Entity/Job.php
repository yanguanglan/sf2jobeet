<?php

namespace Jobeet\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Jobeet\FrontendBundle as Common;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Jobeet\FrontendBundle\Entity\Job
 *
 * @ORM\Table(name="job")
 * @ORM\Entity(repositoryClass="Jobeet\FrontendBundle\Entity\JobRepository")
 */
class Job
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
     * @var string $type
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @var string $company
     *
     * @ORM\Column(name="company", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $company;

    /**
     * @var string $logo
     *
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     * @Assert\Image()
     */
    private $logo;

    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     * @Assert\Url()
     */
    private $url;

    /**
     * @var string $position
     *
     * @ORM\Column(name="position", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $position;

    /**
     * @var string $location
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $location;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var text $howToApply
     *
     * @ORM\Column(name="how_to_apply", type="text", nullable=false)
     * @Assert\NotBlank()
     */
    private $howToApply;

    /**
     * @var string $token
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=false)
     */
    private $token;

    /**
     * @var boolean $isPublic
     *
     * @ORM\Column(name="is_public", type="boolean", nullable=true)
     */
    private $isPublic;

    /**
     * @var boolean $isActivated
     *
     * @ORM\Column(name="is_activated", type="boolean", nullable=true)
     */
    private $isActivated;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var datetime $expiresAt
     *
     * @ORM\Column(name="expires_at", type="datetime", nullable=false)
     */
    private $expiresAt;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

	public function __construct()
	{
		$this->isActivated = false;
		$this->isPublic = true;
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
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set company
     *
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * Get company
     *
     * @return string 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set logo
     *
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set position
     *
     * @param string $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set location
     *
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set howToApply
     *
     * @param text $howToApply
     */
    public function setHowToApply($howToApply)
    {
        $this->howToApply = $howToApply;
    }

    /**
     * Get howToApply
     *
     * @return text 
     */
    public function getHowToApply()
    {
        return $this->howToApply;
    }

    /**
     * Set token
     *
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set isPublic
     *
     * @param boolean $isPublic
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;
    }

    /**
     * Get isPublic
     *
     * @return boolean 
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * Set isActivated
     *
     * @param boolean $isActivated
     */
    public function setIsActivated($isActivated)
    {
        $this->isActivated = $isActivated;
    }

    /**
     * Get isActivated
     *
     * @return boolean 
     */
    public function getIsActivated()
    {
        return $this->isActivated;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set expiresAt
     *
     * @param datetime $expiresAt
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * Get expiresAt
     *
     * @return datetime 
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set category
     *
     * @param Jobeet\FrontendBundle\Entity\Category $category
     */
    public function setCategory(\Jobeet\FrontendBundle\Entity\Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return Jobeet\FrontendBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
    
    public function getSlug($prop)
    {
    	return Common\JobeetFrontendBundle::slugify($this->$prop);
    }
    
    public function isExpired()
    {
    	return $this->daysBeforeExpires() < 0;
    }
    
    public function expiresSoon()
    {
    	return $this->daysBeforeExpires() < 5;
    }
    
    public function daysBeforeExpires()
    {
    	return ceil(
    		( $this->getExpiresAt()->format('U') - time() ) / 86400
    	);
    }
    
    public function extend($days, $force = false)
    {
    	if (!$force && $this->isExpired()) return false;
    	$this->setExpiresAt( new \DateTime( date('Y-m-d H:i:s', time() + 86400*$days) ) );
    	return true;
    }
    
    public function getSlimUrl()
	{
		return preg_replace('|^http(s?)://([a-z0-9\-_.]+)(.*)$|','\\2',$this->getUrl());
	}
	
	public function asIndexArray()
	{
		$index = array(
			'id'			=> $this->getId(),
			'position'		=> $this->getPosition(),
			'company'		=> $this->getCompany(),
			'location'		=> $this->getLocation(),
			'description'	=> $this->getDescription()
		);
		
		return $index;
	}
	
	public function asArray()
	{
		return array(
			'category'     => $this->getCategory()->getName(),
			'type'         => $this->getType(),
			'company'      => $this->getCompany(),
			'logo'         => $this->getLogo(),
			'url'          => $this->getUrl(),
			'position'     => $this->getPosition(),
			'location'     => $this->getLocation(),
			'description'  => $this->getDescription(),
			'how_to_apply' => $this->getHowToApply(),
			'expires_at'   => $this->getExpiresAt()->format('Y-m-d')
		);
	}
	
	public function asJson()
	{
		return json_encode($this->asArray());
	}
}