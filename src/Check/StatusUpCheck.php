<?php

declare(strict_types=1);

namespace SymfonyHealthCheckBundle\Check;

class StatusUpCheck implements CheckInterface
{
    public function check(): CheckResult
    {
        return new CheckResult('up', true);
    }

    public function getResultKey(): string
    {
        return 'status';
    }
}
