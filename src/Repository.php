<?php

namespace Acme\Api;

use Acme\Api\Exception\DuplicateEntryException;
use Acme\Api\Exception\NotFoundException;

/**
 * Repository to query the database
 */
class Repository
{
    /**
     * @var \PDO The connection to the database
     */
    protected $db;

    /**
     * Constructor.
     *
     * @param \PDO $db The connection to the database
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Finds an user by its ID
     *
     * @param int $id The user ID
     *
     * @return array The user
     *
     * @throws NotFoundException When the user doesn't exist
     */
    public function findUser(int $id): array
    {
        $record = $this->execute('SELECT id, name, email FROM users WHERE id = :id', [':id' => $id])
                       ->fetch(\PDO::FETCH_ASSOC);
        if (false === $record) {
            throw new NotFoundException('user not found');
        }

        return $record;
    }

    /**
     * Finds a track by its ID.
     *
     * @param int $id The track ID
     *
     * @return array The track
     *
     * @throws NotFoundException When the track doesn't exist
     */
    public function findTrack(int $id): array
    {
        $record = $this->execute('SELECT id, name, duration FROM tracks WHERE id = :id', [':id' => $id])
                       ->fetch(\PDO::FETCH_ASSOC);
        if (false === $record) {
            throw new NotFoundException('track not found');
        }

        return $record;
    }

    /**
     * Finds tracks for a specific user.
     *
     * @param int $id The user ID
     *
     * @return array The tracks
     */
    public function findUserTracks(int $id): array
    {
        $query = <<<SQL
SELECT t.id, t.name, t.duration
FROM tracks t, user_tracks ut
WHERE t.id = ut.track_id AND ut.user_id = :id 
SQL;

        return $this->execute($query, [':id' => $id])->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Adds a track to a specific user.
     *
     * @param int $userId  The user ID
     * @param int $trackId The track ID
     */
    public function addUserTrack(int $userId, int $trackId)
    {
        try {
            $this->execute('INSERT INTO user_tracks (user_id, track_id) VALUE (:uid, :tid)', [
                ':uid' => $userId,
                ':tid' => $trackId,
            ]);
        } catch (DuplicateEntryException $ex) {

        }
    }

    /**
     * Removes a track from a specific user.
     *
     * @param int $userId  The user ID
     * @param int $trackId The track ID
     */
    public function removeUserTrack(int $userId, int $trackId)
    {
        $this->execute('DELETE FROM user_tracks WHERE user_id = :uid AND track_id = :tid', [
            ':uid' => $userId,
            ':tid' => $trackId,
        ]);
    }

    /**
     * Executes a parameterized query and returns a statement.
     *
     * @param string $query  The query
     * @param array  $params The parameters
     *
     * @return \PDOStatement The resulting statement
     *
     * @throws \Exception When an error occurred
     */
    protected function execute(string $query, array $params = []): \PDOStatement
    {
        $stmt = $this->db->prepare($query);
        if (false === $stmt) {
            throw new \Exception('cannot prepare statement');
        }
        if (false === $stmt->execute($params)) {
            if ($stmt->errorCode() == 23000) {
                throw new DuplicateEntryException();
            }

            throw new \Exception('cannot execute statement');
        }

        return $stmt;
    }
}
