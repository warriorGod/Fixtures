<?php declare(strict_types=1);

namespace DavidBadura\Fixtures\Persister;

use DavidBadura\Fixtures\Fixture\FixtureData;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author David Badura <d.badura@gmx.de>
 */
class DoctrinePersister implements PersisterInterface
{
    private $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function persist(FixtureData $data): void
    {
        $object = $data->getObject();

        $metadata = $this->om->getClassMetadata(get_class($object));
        $identifier = $metadata->getIdentifier();

        if ($metadata->usesIdGenerator()
            && count(array_intersect($identifier, array_keys($data->getData()))) > 0
        ) {
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
        }
        
        $this->om->persist($object);
    }

    public function flush(): void
    {
        $this->om->flush();
    }
}
