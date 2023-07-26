<?php
// authMiddleware.php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Tuupola\Middleware\CorsMiddleware;

$apiKeyVerifier = function(Request $request, RequestHandler $handler) {

    $database = new \Ogunerkutay\ChatBackend\Database();
    $connection = $database->getConnection();
    
    $query = 'SELECT * FROM users WHERE username = :username';
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':username', $data['username']);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user || !password_verify($data['password'], $user['password'])) {
        $response->getBody()->write(json_encode(['error' => 'Invalid credentials']));
        return $response->withStatus(401);
    }
    
    $response->getBody()->write(json_encode(['success' => 'User authenticated', 'user_id' => $user['id']]));
    return $response->withStatus(200);
};

function sendErrorResponse($error) {
    $response = new Response();
    $response->getBody()->write(json_encode($error));
    $newResponse = $response->withStatus(401);
    return $newResponse;
}

// function basicAuth($request, $handler)
// {
//     $username = 'your_username';
//     $password = 'your_password';

//     $headers = $request->getHeaders();
//     if (isset($headers['Authorization'][0])) {
//         $authHeader = $headers['Authorization'][0];
//         list($usernameInput, $passwordInput) = explode(':', base64_decode(substr($authHeader, 6)));
//         if ($usernameInput === $username && $passwordInput === $password) {
//             // User is authenticated; proceed with the request
//             return $handler->handle($request);
//         }
//     }

//     // User is not authenticated; send 401 Unauthorized response
//     $response = new Response();
//     return $response->withStatus(401)
//         ->withHeader('WWW-Authenticate', 'Basic realm="My Protected Area"')
//         ->withHeader('Content-Type', 'text/html');
// }
?>
