<?php

declare(strict_types=1);

namespace SymfonyHealthCheckBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyHealthCheckBundle\Check\CheckInterface;

final class HealthController extends AbstractController
{
    /**
     * @var array<CheckInterface>
     */
    private array $healthChecks = [];

    public function addHealthCheck(CheckInterface $healthCheck): void
    {
        $this->healthChecks[] = $healthCheck;
    }

    /**
     * @Route(
     *     path="/health",
     *     name="health",
     *     methods={"GET"}
     * )
     */
    public function healthCheckAction(): JsonResponse
    {
        $resultHealthCheck = [];
        $allHealthy = true;
        foreach ($this->healthChecks as $healthCheck) {
            $checkResult = $healthCheck->check();
            $allHealthy &= $checkResult->isHealthy();
            $resultHealthCheck[$healthCheck->getResultKey()] = $checkResult;
        }

        return new JsonResponse(
            $resultHealthCheck,
            $allHealthy ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
