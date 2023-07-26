<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
require_once __DIR__ . '../model.php';

class Service{

    public function handler_register(Request $request, Response $response ){
            // Get the request data
            $body = (string)$request->getBody();
            $data = json_decode($body, true);

        // Validate the input
        if (!isset($data['username']) || !isset($data['password'])) {
            $response->getBody()->write(json_encode(['error' => 'Invalid input']));
            return $response->withStatus(400);
        }

        // Check if the user already exists in the database
        $model = new Model();
        if ($model->getUsers($data)) {
            $response->getBody()->write(json_encode(['error' => 'User already exists']));
            return $response->withStatus(409);
        }

        // Add the new user in the database
        $model->addnewUsers($data);
        $response->getBody()->write(json_encode(['success' => 'User registered']));
        return $response->withStatus(201);

    }
    
    public function handler_create_group(Request $request, Response $response ){
        // Get the request data
        $body = (string)$request->getBody();
        $data = json_decode($body, true);

        // Validate the input
        if (!isset($data['group_id']) || !isset($data['user_id'])) {
            $response->getBody()->write(json_encode(['error' => 'Invalid input']));
            return $response->withStatus(400);
        }

        // Check if the group already exists in the database
        $model = new Model();
        if ($model->getGroups($data)) {
            $response->getBody()->write(json_encode(['error' => 'Group already exists']));
            return $response->withStatus(409);
        }

        // Add the new group in the groups database and add the user->group mapping to user_groups database
        $model->addnewGroups($data);
        $model->addUser_Groups($data);
        $response->getBody()->write(json_encode(['success' => 'Group_created']));
        return $response->withStatus(201);
    }

    public function handler_join_group(Request $request, Response $response) {
            
        // Get the request data
        $body = (string)$request->getBody();
        $data = json_decode($body, true);

        // Validate the input
        if (!isset($data['group_id']) || !isset($data['user_id'])) {
            $response->getBody()->write(json_encode(['error' => 'Invalid input']));
            return $response->withStatus(400);
        }

        // Check if the user already exists in group or check if group exists or not
        $model = new Model();
        if ($model->getUsers_Groups($data) || !($model->getGroups($data))) {
            $response->getBody()->write(json_encode(['error' => 'User already joined or group does not exists']));
            return $response->withStatus(409);
        }

        // Add the new user to that group adn do user->group mapping
        $model->addUser_Groups($data);
        $response->getBody()->write(json_encode(['success' => 'User registered']));
        return $response->withStatus(201);
    }


    public function handler_post_message(Request $request, Response $response) {
            
        // Get the request data
        $body = (string)$request->getBody();
        $data = json_decode($body, true);

        // Validate the input
        if (!isset($data['group_id']) || !isset($data['user_id'])) {
            $response->getBody()->write(json_encode(['error' => 'Invalid input']));
            return $response->withStatus(400);
        }

        // Check user exists in the group he is messaging
        $model = new Model();
        if ($model->getUsers_Groups($data)) {
            // Save the message
            $model = new Model();
            $model->saveMessage($data);
            $response->getBody()->write(json_encode(['success' => 'Message sent']));
            return $response->withStatus(201);
        }

        $response->getBody()->write(json_encode(['error' => 'User Should join this group to send message']));
        return $response->withStatus(409); 

    }


    public function handler_get_message(Request $request, Response $response) {

        $body = (string)$request->getBody();
        $data = json_decode($body, true);

        // Validate the input
        if (!isset($data['group_id']) || !isset($data['user_id'])) {
            $response->getBody()->write(json_encode(['error' => 'Invalid input insert group_id ']));
            return $response->withStatus(400);
        }

        // Check user exists in that group
        $model = new Model();
        if ($model->getUsers_Groups($data)) {
                // Fetch messages
                $model = new Model();
                $messagesFetched = $model->fetchMessage($data);
                $response->getBody()->write(json_encode(['messages' => $messagesFetched]));
                return $response->withStatus(200);
        }
        $response->getBody()->write(json_encode(['error' => 'User Should join this group to get message']));
        return $response->withStatus(409); 
    }
}