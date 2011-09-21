<?php
namespace Jobeet\FrontendBundle\Tests;

use Doctrine\Tests\OrmTestCase;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping\Driver\DriverChain;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

class EntityTestCase extends OrmTestCase
{
    private $_em;

    protected function setUp()
    {
        $reader = new AnnotationReader();
        $reader->setIgnoreNotImportedAnnotations(true);
        $reader->setEnableParsePhpImports(true);

        $metadataDriver = new AnnotationDriver(
            $reader,
            'Jobeet\\FrontendBundle\\Entity'
        );

        $this->_em = $this->_getTestEntityManager();

        $this->_em->getConfiguration()
            ->setMetadataDriverImpl($metadataDriver);

        $this->_em->getConfiguration()->setEntityNamespaces(array(
            'JobeetFrontendBundle' => 'Jobeet\\FrontendBundle\\Entity'
        ));
    }
}