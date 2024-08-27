<?php

use App\Http\Controllers\BlogController;
use App\Services\ViewService;

$requestUri = $_SERVER['REQUEST_URI'];

$blog = new BlogController();
$viewService = new ViewService();

if ($requestUri === "/" || str_contains($requestUri, '/index.php')) {
    $blog->showMessagesList();
} elseif (str_contains($requestUri, '/message/delete')) {
    $raw = file_get_contents('php://input');
    $json = json_decode($raw);

    echo $blog->deleteMessage($json->message_id);
} elseif (str_contains($requestUri, '/message/add')) {
    $raw = file_get_contents('php://input');
    $json = json_decode($raw);

    echo $blog->addMessage($json);
} elseif (str_contains($requestUri, '/message/edit')) {
    $raw = file_get_contents('php://input');
    $json = json_decode($raw);

    echo $blog->editMessage($json);
} elseif (str_contains($requestUri, '/message/show/')) {
    $messageId = str_replace('/message/show/', '', $requestUri);

    if (!is_numeric($messageId)) {
        echo $viewService->renderPageNotFound();
    }

    $blog->showMessage($messageId);
} elseif (str_contains($requestUri, '/comment/add')) {
    $raw = file_get_contents('php://input');
    $json = json_decode($raw);

    echo $blog->addComment($json);
} else {
    echo $viewService->renderPageNotFound();
}