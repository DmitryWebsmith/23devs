<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Message;
use App\Services\ViewService;

class BlogController
{
    private ViewService $viewService;
    private Message $message;
    private Comment $comment;

    public function __construct()
    {
        $this->viewService = new ViewService();
        $this->message = new Message();
        $this->comment = new Comment();
    }

    public function showMessagesList(): void
    {
        $messages = $this->message->getAllMessages();

        echo $this->viewService->render('index', ['messages' => $messages]);
    }

    public function showMessage(int $messageId): void
    {
        $message = $this->message->getMessage($messageId);

        echo $this->viewService->render('message', [
            'message' => $message,
            'comments' => $this->comment->getAllComments($messageId),
        ]);
    }

    public function deleteMessage(int $messageId): string
    {
        $result = $this->message->deleteMessage($messageId);

        if ($result['status']) {
            return json_encode([
                'status' => true,
                'messages' => $this->message->getAllMessages(),
            ]);
        }

        return json_encode([
            'status' => false,
            'message' => $result['message'],
        ]);
    }

    public function addMessage(object $json): string
    {
        $result = $this->message->addMessage($json);

        if ($result['status']) {
            return json_encode([
                'status' => true,
                'messages' => $this->message->getAllMessages(),
            ]);
        }

        return json_encode([
            'status' => false,
            'message' => $result['message'],
        ]);
    }

    public function addComment(object $json): string
    {
        $result = $this->comment->addComment($json);

        if ($result['status']) {
            return json_encode([
                'status' => true,
                'comments' => $this->comment->getAllComments($json->message_id),
            ]);
        }

        return json_encode([
            'status' => false,
            'message' => $result['message'],
        ]);
    }

    public function editMessage(object $json): string
    {
        $result = $this->message->editMessage($json);

        if ($result['status']) {
            return json_encode([
                'status' => true,
                'messages' => $this->message->getAllMessages(),
            ]);
        }

        return json_encode([
            'status' => false,
            'message' => $result['message'],
        ]);
    }
}
