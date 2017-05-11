Requirements
============
* PHP >= 5.6.30
* Laravel >= 1.3.5

```
- Register with any of 3 different types of profile(Reader, Blogger, Admin).
- Reader can only read blogs.
- Blogger can edit, create and delete his own blogs and read all blogs.
- Admin can read, edit, create, delete any blog.
```

# Quick start
- Clone this repository on your local machine in your server directory.

- Change the <code>Blogger/.env</code> file to enter your own credentials.
```
DB_CONNECTION=mysql
DB_HOST="YOUR_HOST_NAME"      //say localhost or 127.0.0.1
DB_PORT="YOUR_PORT_NUMBER"    //say 3306
DB_DATABASE=dentalkart        //Keep this same for now.
DB_USERNAME=root              //change it with your username
DB_PASSWORD=''                //change it with your password if any
```
- Open command prompt or terminal at your project directory and write commands.
```
php artisan serve
php artisan migrate
```

- You're good to go. Go to <code>localhost:8000</code> to see it inaction.
