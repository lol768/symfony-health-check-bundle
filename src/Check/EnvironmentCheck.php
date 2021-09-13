<?php

declare(strict_types=1);

namespace SymfonyHealthCheckBundle\Check;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Throwable;

class EnvironmentCheck implements CheckInterface
{
    private const CHECK_RESULT_KEY = 'environment';

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function check(): CheckResult
    {
        try {
            $env = $this->container->getParameter('kernel.environment');
            return new CheckResult($env, true);
        } catch (Throwable $e) {
            return new CheckResult('Could not determine', false);
        }
    }

    public function getResultKey(): string
    {
        return self::CHECK_RESULT_KEY;
    }
}
