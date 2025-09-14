<?php
namespace NgsHarco\ParticipantAnniversary\Core\Content\Participant;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\CreatedAtField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\DateField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\EmailField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\UpdatedAtField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\UuidField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class ParticipantDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'ngs_harco_participant';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return ParticipantEntity::class;
    }

    public function getCollectionClass(): string
    {
        return ParticipantCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new UuidField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            (new StringField('first_name', 'firstName'))->addFlags(new Required()),
            (new StringField('last_name', 'lastName'))->addFlags(new Required()),
            (new EmailField('email', 'email'))->addFlags(new Required()),
            (new DateField('work_start_date', 'workStartDate'))->addFlags(new Required()),
            new DateField('work_end_date', 'workEndDate'),
            new CreatedAtField(),
            new UpdatedAtField(),
        ]);
    }
}
