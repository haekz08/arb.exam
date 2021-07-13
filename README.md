# Jeofer Chris Basanes
### Senior Developer Exam- ARB Call Facilities

##### Laravel Version (7.8.1)
##### VueJs Version (2.6.11)

## Installation

##### 1. Clone GitHub repo for this project locally1. Clone GitHub repo for this project locally
`git clone https://github.com/haekz08/arb.exam.git`

##### 2. cd into backend folder
`cd backend`
##### 3. Install Composer Dependencies
`composer install`
##### 4. Create a copy of your .env file
`copy .env.example .env`
##### 5. Generate an app encryption key
`php artisan key:generate`

##### 6. Create an empty database for our application


##### 7. In the .env file, add database information to allow Laravel to connect to the database

##### 8. Migrate the database
`php artisan migrate`

##### 9. Seed the database
`php artisan db:seed`
##### 10. Install the Passport and copy the "Client secret" value which "client ID" is "2" (Line Number 6 below)
`php artisan passport:install`


    Personal access client created successfully.
    Client ID: 1
    Client secret: jOeR2YOxW56DVgohLM5HyQFpc91kNudcsRWKcL5v
    Password grant client created successfully.
    Client ID: 2
    Client secret: kDT8IIPPCcZI7AMYcnKE9ruEPR3TH4cm9gbYYt3r
##### 12. cd to frontend folder
`cd ../frontend`
##### 13. Install NPM Dependencies
`npm install`
##### 14. Open in text editor "frontend/src/config.js" and paste the "client secret" at line number 4.
You may change the **server_url** and **assets_url** according to your configuration.

    let server_url="http://127.0.0.1:8000";
    let backend_url=server_url+'';
    let assets_url='http://localhost:8080/';
    let server_client_secret="jvxQ8OsNXQVIay1ZWpRgfdIaSjBjE050ls7zQGZ4";
    
    export const assets_path = Object.freeze({
        DEFAULT_URL: assets_url
    });
    export const client_details = Object.freeze({
        CLIENT_ID: "2",
        CLIENT_SECRET: server_client_secret
    });
    export const server_details = Object.freeze({
        SERVER_URL: backend_url+"/api/",
    });

##### 15. Run your frontend
`npm run serve`
##### 16. Run your backend
`php artisan serve`