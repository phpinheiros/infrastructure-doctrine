<?php
namespace Phpinheiros\Infrastructure\Doctrine;

use Doctrine\ORM\EntityRepository as EntityRepositoryBase;
use Phpinheiros\Infrastructure\ORM\ISpecificationCriteria;
use Phpinheiros\Infrastructure\ORM\IEntity;
use Phpinheiros\Infrastructure\ORM\IRepository;

class EntityRepository extends EntityRepositoryBase implements IRepository
{

    public function add(IEntity $object)
    {
        $this->exceptionOnInvalidEntityType($object);
        $this->getEntityManager()->persist($object);
    }

    public function remove(IEntity $object)
    {
        $this->exceptionOnInvalidEntityType($object);
        $this->getEntityManager()->remove($object);
    }

    public function update(IEntity $entity)
    {
        $this->getEntityManager()->merge($entity);
    }

    public function findById($id)
    {
        return $this->find($id);
    }

    public function findBySpecification(ISpecificationCriteria $specification)
    {
        return $this->matching($specification->getCriteria()
            ->setMaxResults(1))
            ->first() ?  : null;
    }

    public function findAll()
    {
        return parent::findAll();
    }

    public function findAllBySpecification(ISpecificationCriteria $specification)
    {
        return $this->matching($specification->getCriteria());
    }

    private function exceptionOnInvalidEntityType(IEntity $object)
    {
        if (get_class($object) !== $this->_entityName) {
            throw new \InvalidArgumentException(sprintf('Invalid entity type %s supplied for repository of %s', $this->_entityName, get_class($object)));
        }
    }
}