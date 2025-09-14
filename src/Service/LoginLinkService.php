<?php
namespace NgsHarco\ParticipantAnniversary\Service;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LoginLinkService
{
    public function __construct(private readonly UrlGeneratorInterface $router)
    {
    }

    public function build(string $token): string
    {
        return $this->router->generate('frontend.ngs_harco.access', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
    }
}
