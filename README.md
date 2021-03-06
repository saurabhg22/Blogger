# Blogger
```
- Register with any one of the 3 different types of profiles(Reader, Blogger, Admin).
- Reader can only read blogs.
- Blogger can edit, create and delete his own blogs and read all blogs.
- Admin can read, edit and delete any blog.
```

Requirements
============
* PHP >= 5.6.30
* Laravel >= 1.3.5


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
php artisan migrate
php artisan serve

```

- You're good to go. Go to <code>localhost:8000</code> to see it inaction.


Screenshots

- Landing page after login

![Alt text](/screenshots/Etale.png "Demo")

- New Blog Creator

![Alt text](/screenshots/Etale1.png "Demo")

- Blog Details page

![Alt text](/screenshots/Etale2.png "Demo")

- Blog Editor

![Alt text](/screenshots/Etale3.png "Demo")

- Profile to see all your blogs

![Alt text](/screenshots/Etale4.png "Demo")

- User Registration

![Alt text](/screenshots/Etale5.png "Demo")

- Login Page

![Alt text](/screenshots/Etale6.png "Demo")
