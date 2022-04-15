##About BST
BST is a web application to manage it's staffs, tasks, status of tasks, etc.


##Installation
- Create a new .env file rename the .env.example file to .env
- Open command prompt
- Run below command to generate new key:
	- php artisan key:generate
- Run below command:
	- composer update (It will update your packages)
- Change your DB details and mail server credentials in .env file
- Run commands: 
    - npm install
    - npm run dev
	- php artisan config:cache
	- php artisan cache:clear
	- php artisan migrate --seed (It will migrate your all table in database)
	- php artisan serve (It will run your project on 127.0.0.1:8000)