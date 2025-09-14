<?php
namespace NgsHarco\ParticipantAnniversary\Service;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeService
{
    public function generateDataUri(string $text, int $size): string
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($text)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->size($size)
            ->build();

        return 'data:image/png;base64,' . base64_encode($result->getString());
    }
}
