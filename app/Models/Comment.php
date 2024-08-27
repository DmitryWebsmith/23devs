<?php

namespace App\Models;

use App\Services\DatabaseService;

class Comment
{
    private DatabaseService $database;

    public function __construct() {
        $this->database = new DatabaseService();;
    }

    public function getAllComments(int $messageId): array|null
    {
        $db = $this->database->connect();

        if ($db === null) {
            return null;
        }

        $sql = "SELECT * FROM comments WHERE message_id = " . $messageId;
        $result = $db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addComment(object $json): array
    {
        $db = $this->database->connect();

        $id = $this->database->getMaxId('comments') + 1;
        $messageId = $json->message_id;
        $author = $json->author;
        $comment = $json->comment;

        $sql = "INSERT INTO comments (id, author, message_id, comment) VALUES ('".$id."','".$author."','".$messageId."','".$comment."')";

        if ($db->query($sql) === true) {
            return ['status' => true];
        }

        return [
            'status' => false,
            'message' => 'Error adding record: ' . $db->error,
        ];
    }
}
