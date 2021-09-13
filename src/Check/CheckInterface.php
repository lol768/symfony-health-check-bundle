<?php

declare(strict_types=1);

namespace SymfonyHealthCheckBundle\Check;

interface CheckInterface
{
    /**
     * @return CheckResult
     */
    public function check(): CheckResult;

    /**
     * @return string The key to identify this health check
     */
    public function getResultKey(): string;
}
