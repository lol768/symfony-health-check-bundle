<?php

declare(strict_types=1);

namespace SymfonyHealthCheckBundle\Check;

use Symfony\Component\DependencyInjection\ContainerInterface;
use SymfonyHealthCheckBundle\Exception\ServiceNotFoundException;
use Throwable;

class DoctrineCheck implements CheckInterface
{
    private const CHECK_RESULT_KEY = 'connection';

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getResultKey(): string
    {
        return self::CHECK_RESULT_KEY;
    }

    /**
     * @throws ServiceNotFoundException
     */
    public function check(): CheckResult
    {
        $result = ['name' => 'doctrine'];

        if ($this->container->has('doctrine.orm.entity_manager') === false) {
            throw new ServiceNotFoundException(
                'Entity Manager Not Found.',
                [
                    'class' => 'doctrine.orm.entity_manager',
                ]
            );
        }

        $entityManager = $this->container->get('doctrine.orm.entity_manager');

        if ($entityManager === null) {
            throw new ServiceNotFoundException('Entity Manager Not Found.');
        }

        $retVal = false;
        try {
            $retVal = $entityManager->getConnection()->ping();
            if (!$retVal) {
                return new CheckResult('Failed to ping', false);
            }
        } catch (Throwable $e) {
            return new CheckResult('Failed to ping', false);
        }

        return new CheckResult(
            "Ping successful with driver {$entityManager->getConnection()->getDriver()->getName()}",
            $retVal
        );
    }
}
