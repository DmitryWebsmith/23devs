<?php

namespace App\Models;

use App\Services\DatabaseService;

class Message
{
    private DatabaseService $database;

    public function __construct() {
        $this->database = new DatabaseService();
    }

    public function addMessage(object $json): array
    {
        $db = $this->database->connect();

        $id = $this->database->getMaxId('messages') + 1;
        $author = $json->author;
        $title = $json->title;
        $summary = $json->summary;
        $content = $json->content;

        $sql = "INSERT INTO messages (id, author, title, summary, content) VALUES ('".$id."','".$author."','".$title."','".$summary."','".$content."')";

        if ($db->query($sql) === true) {
            return ['status' => true];
        }

        return [
            'status' => false,
            'message' => 'Error adding record: ' . $db->error,
        ];
    }

    public function editMessage(object $json): array
    {
        $db = $this->database->connect();

        $id = $json->id;
        $author = $json->author;
        $title = $json->title;
        $summary = $json->summary;
        $content = $json->content;

        $sql = "UPDATE messages SET author='".$author."', title='".$title."', summary='".$summary."', content='".$content."' WHERE id='".$id."'";

        if ($db->query($sql) === true) {
            return ['status' => true];
        }

        return [
            'status' => false,
            'message' => 'Error deleting record: ' . $db->error,
        ];
    }

    public function getMessage(int $messageId): object|null
    {
        $db = $this->database->connect();

        if ($db === null) {
            return null;
        }

        $sql = "SELECT * FROM messages WHERE id = " . $messageId;
        $result = $db->query($sql);

        return $result->fetch_object();
    }

    public function deleteMessage(int $messageId): array
    {
        $db = $this->database->connect();

        $sql = "DELETE FROM messages WHERE id = " . $messageId;

        if ($db->query($sql) === true) {
            $sql = "DELETE FROM comments WHERE message_id = " . $messageId;
            $db->query($sql);

            return ['status' => true];
        }

        return [
            'status' => false,
            'message' => 'Error deleting record: ' . $db->error,
        ];
    }

    public function getAllMessages(): array|null
    {
        $db = $this->database->connect();

        if ($db === null) {
            return null;
        }

        $sql = "SELECT * FROM messages";
        $result = $db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
