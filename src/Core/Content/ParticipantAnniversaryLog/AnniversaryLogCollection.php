<?php
namespace NgsHarco\ParticipantAnniversary\Core\Content\ParticipantAnniversaryLog;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void                add(AnniversaryLogEntity $entity)
 * @method void                set(string $key, AnniversaryLogEntity $entity)
 * @method AnniversaryLogEntity[]    getIterator()
 * @method AnniversaryLogEntity[]    getElements()
 * @method AnniversaryLogEntity|null get(string $key)
 * @method AnniversaryLogEntity|null first()
 * @method AnniversaryLogEntity|null last()
 */
class AnniversaryLogCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return AnniversaryLogEntity::class;
    }
}
