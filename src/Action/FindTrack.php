<?php

namespace Acme\Api\Action;

use Acme\Api\DelegateInterface;
use Acme\Api\Request;
use Acme\Api\Response;

/**
 * Finds a specific track
 */
class FindTrack extends AbstractAction
{
    public function process(Request $request, DelegateInterface $delegate): Response
    {
        list($id) = $request->getAttributes();

        return new Response($this->repository->findTrack($id), 200);
    }
}
