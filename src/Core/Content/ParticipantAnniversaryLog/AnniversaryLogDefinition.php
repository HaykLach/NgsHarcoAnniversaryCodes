<?php
namespace NgsHarco\ParticipantAnniversary\Core\Content\ParticipantAnniversaryLog;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\CreatedAtField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\DateTimeField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IntField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\UuidField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class AnniversaryLogDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'ngs_harco_participant_anniversary_log';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return AnniversaryLogEntity::class;
    }

    public function getCollectionClass(): string
    {
        return AnniversaryLogCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new UuidField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            (new UuidField('participant_id', 'participantId'))->addFlags(new Required()),
            (new IntField('anniversary_year', 'anniversaryYear'))->addFlags(new Required()),
            new UuidField('level_product_id', 'levelProductId'),
            (new StringField('token', 'token'))->addFlags(new Required()),
            (new DateTimeField('token_expires_at', 'tokenExpiresAt'))->addFlags(new Required()),
            new DateTimeField('used_at', 'usedAt'),
            (new DateTimeField('sent_at', 'sentAt'))->addFlags(new Required()),
            new CreatedAtField(),
        ]);
    }
}
