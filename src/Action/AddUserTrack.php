<?php

namespace Acme\Api\Action;

use Acme\Api\DelegateInterface;
use Acme\Api\Request;
use Acme\Api\Response;

/**
 * Adds a track to a specific user.
 */
class AddUserTrack extends AbstractAction
{
    public function process(Request $request, DelegateInterface $delegate): Response
    {
        list($userId, $trackId) = $request->getAttributes();

        $this->repository->addUserTrack($userId, $trackId);

        return new Response([
            'message' => sprintf('track #%d added to user #%d', $trackId, $userId)
        ], 201);
    }
}
