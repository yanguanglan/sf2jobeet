<?php

namespace Jobeet\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jobeet\FrontendBundle\Entity\CategoryAffiliate
 *
 * @ORM\Table(name="categoryaffiliate")
 * @ORM\Entity
 */
class CategoryAffiliate
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer $category_id
     *
     * @ORM\Column(name="category_id", type="integer")
     */
    private $category_id;

    /**
     * @var integer $affiliate_id
     *
     * @ORM\Column(name="affiliate_id", type="integer")
     */
    private $affiliate_id;


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
     * Set category_id
     *
     * @param integer $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->category_id = $categoryId;
    }

    /**
     * Get category_id
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set affiliate_id
     *
     * @param integer $affiliateId
     */
    public function setAffiliateId($affiliateId)
    {
        $this->affiliate_id = $affiliateId;
    }

    /**
     * Get affiliate_id
     *
     * @return integer 
     */
    public function getAffiliateId()
    {
        return $this->affiliate_id;
    }
}