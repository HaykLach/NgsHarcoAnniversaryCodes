<?php
namespace NgsHarco\ParticipantAnniversary\Controller\Storefront;

use NgsHarco\ParticipantAnniversary\Service\ConfigService;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccessController extends StorefrontController
{
    public function __construct(
        private readonly EntityRepository $anniversaryLogRepository,
        private readonly ConfigService $config,
    ) {
    }

    #[Route(path: '/ngs-harco/access/{token}', name: 'frontend.ngs_harco.access', methods: ['GET'])]
    public function access(string $token, Request $request, SalesChannelContext $salesChannelContext): Response
    {
        $criteria = (new Criteria())->addFilter(new EqualsFilter('token', $token));
        $log = $this->anniversaryLogRepository->search($criteria, $salesChannelContext->getContext())->first();
        if (!$log) {
            return $this->createErrorResponse();
        }
        if ($log->getUsedAt() || $log->getTokenExpiresAt() < new \DateTimeImmutable()) {
            return $this->createErrorResponse();
        }

        $this->anniversaryLogRepository->update([
            ['id' => $log->getId(), 'usedAt' => new \DateTimeImmutable()],
        ], $salesChannelContext->getContext());

        $request->getSession()->set('ngsHarco.levelProductId', $log->getLevelProductId());

        $level = $this->config->findLevelForYears($log->getAnniversaryYear());
        $categoryId = $level['targetCategoryId'] ?? $this->config->fallbackCategoryId();
        if ($categoryId) {
            return $this->redirectToRoute('frontend.navigation.page', ['navigationId' => $categoryId]);
        }

        return $this->redirectToRoute('frontend.home.page');
    }

    private function createErrorResponse(): Response
    {
        return $this->renderStorefront('@Storefront/storefront/page/content/not-found.html.twig', []);
    }
}
