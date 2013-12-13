<?php
namespace Phpinheiros\Infrastructure\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Phpinheiros\Infrastructure\ORM\IUnitOfWork;

class UnitOfWork implements IUnitOfWork
{

    private $doctrine;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function commit()
    {
        $this->doctrine->getManager()->flush();
    }
}