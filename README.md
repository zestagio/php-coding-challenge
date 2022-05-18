## Description

The project created as PHP Coding Challenge to demonstrate REST API implementation
using <a href="https://api-platform.com">API Platform</a>. It shouldn't be used
in the real PROD environment as it. The project contains **Generic High Entropy 
Secret** explosion because the **.env** contains secret keys, db
username, password, etc. It was done just for quick installation and testing purposes.

## Installation
- Clone the repository to local machine
- Run `docker-compose up -d` (it creates db container without web server)
- Make sure you have a local server to handle requests
- Run `composer install`

## Usage
After execution `composer install` the application is ready. Go to homepage, 
and you will see the publicly available swagger UI.

As an anonymous user you are able to retrieve data. You can authorise using
JWT token via `authentication_token` URL and use the received token to perform 
POST and DELETE requests.
