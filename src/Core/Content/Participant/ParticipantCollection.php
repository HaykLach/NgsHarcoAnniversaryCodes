<?php
namespace NgsHarco\ParticipantAnniversary\Core\Content\Participant;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void              add(ParticipantEntity $entity)
 * @method void              set(string $key, ParticipantEntity $entity)
 * @method ParticipantEntity[]    getIterator()
 * @method ParticipantEntity[]    getElements()
 * @method ParticipantEntity|null get(string $key)
 * @method ParticipantEntity|null first()
 * @method ParticipantEntity|null last()
 */
class ParticipantCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return ParticipantEntity::class;
    }
}
