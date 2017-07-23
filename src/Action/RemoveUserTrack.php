<?php

namespace Acme\Api\Action;

use Acme\Api\DelegateInterface;
use Acme\Api\Request;
use Acme\Api\Response;

/**
 * Removes a track from a specific user
 */
class RemoveUserTrack extends AbstractAction
{
    public function process(Request $request, DelegateInterface $delegate): Response
    {
        list($userId, $trackId) = $request->getAttributes();

        $this->repository->addUserTrack($userId, $trackId);

        return new Response([
            'message' => sprintf('track #%d removed from user #%d', $trackId, $userId)
        ], 200);
    }
}
