<?php

namespace Acme\Api\Action;

use Acme\Api\MiddlewareInterface;
use Acme\Api\Repository;

/**
 * A repository aware abstract action.
 */
abstract class AbstractAction implements MiddlewareInterface
{
    /**
     * @var Repository The repository
     */
    protected $repository;

    /**
     * Constructor.
     *
     * @param Repository $repository The repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }
}
