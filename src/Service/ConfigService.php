<?php
namespace NgsHarco\ParticipantAnniversary\Service;

use Shopware\Core\System\SystemConfig\SystemConfigService;

class ConfigService
{
    private const CONFIG_DOMAIN = 'NgsHarcoParticipantAnniversary.config.';

    public function __construct(private readonly SystemConfigService $configService)
    {
    }

    public function getLevelMappings(): array
    {
        return $this->configService->get(self::CONFIG_DOMAIN . 'levelMappings') ?? [];
    }

    public function findLevelForYears(int $years): ?array
    {
        foreach ($this->getLevelMappings() as $mapping) {
            if ((int) ($mapping['years'] ?? 0) === $years) {
                return $mapping;
            }
        }

        return null;
    }

    public function tokenTtlDays(): int
    {
        return (int) ($this->configService->get(self::CONFIG_DOMAIN . 'tokenTtlDays') ?? 7);
    }

    public function generateQrCode(): bool
    {
        return (bool) ($this->configService->get(self::CONFIG_DOMAIN . 'generateQrCode') ?? false);
    }

    public function qrSize(): int
    {
        return (int) ($this->configService->get(self::CONFIG_DOMAIN . 'qrSize') ?? 256);
    }

    public function fallbackCategoryId(): ?string
    {
        return $this->configService->get(self::CONFIG_DOMAIN . 'fallbackCategoryId');
    }
}
