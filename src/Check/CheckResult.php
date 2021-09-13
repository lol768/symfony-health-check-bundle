<?php

declare(strict_types=1);

namespace SymfonyHealthCheckBundle\Check;

use JsonSerializable;

class CheckResult implements JsonSerializable
{
    /** @var mixed */
    private $data;

    /** @var boolean */
    private bool $isHealthy;

    /**
     * CheckResult constructor.
     *
     * @param mixed $data Data to show in JSON response from HealthController endpoint.
     * @param bool  $isHealthy Whether this result is considered healthy or not.
     */
    public function __construct($data, bool $isHealthy)
    {
        $this->data = $data;
        $this->isHealthy = $isHealthy;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return bool
     */
    public function isHealthy(): bool
    {
        return $this->isHealthy;
    }

    public function jsonSerialize(): array
    {
        return [
            'result' => $this->data,
            'healthy' => $this->isHealthy
        ];
    }
}
