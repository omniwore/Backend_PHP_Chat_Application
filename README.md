
Clone the repository.
Run composer install to install dependencies.
Ensure the database folder has write permissions.
Start the PHP development server by running php -S localhost:8000 -t public from the project root.
The API is now available at http://localhost:8000.

API endpoints:

POST /register_user: To register new user.
{//sample body input

"username": "Bunty",            
"password": "okok"

}
POST /create_group: To create a new group.
{

"user_id":"10",
"group_name":"bunq",
"group_id":"200"

}
POST /join_group: To join a already made group.
{
"user_id":"2",
"group_id":"200"
}

POST /post_messages: To send message in a group which you have joined.
{

"user_id":"7",
"content":"Lets!! Get Shit Done",
"group_id":"200"

}
GET /get_messages: To Retrieve all messages in the group chat.
{

"user_id":"4",
"group_id":"200"

}
