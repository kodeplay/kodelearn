# Kodelearn - OpenSource Learning Management System. 

HomePage: [www.kodelearn.com](http://www.kodelearn.com)

Authors: Team [Kodeplay](http://www.kodeplay.com)

## What is Kodelearn ?
Kodelearn is a web based learning management system that can be used by 
educational institutions such as schools, universities to manage students, 
teachers, course content, lectures, exams, results, attendance etc and to 
engage students, their parents and teachers through an easy to use interface.

## What platform is Kodelearn based on ?

Kodelearn is written in PHP using the Kohana PHP Framework (v3.1)

## Installation instructions

#### Downloading Source Code
  * Download the stable source code from
    [Kodelearn website](http://kodelearn.com/kodelearn.tar.gz)
  
  * Or clone from github specially if you are looking to hack around
    
    ```bash 
    $ git clone git@github.com:kodeplay/kodelearn.git
    ```
    
    You will also need to update the submodules by running the command
  
    ```bash
    $ cd kodelearn
    $ git submodule init
    $ git submodule update
    ```

    We are using a [purifier](https://github.com/shadowhand/purifier)
    module for XSS filtering Since this module also has its own
    submodules, you will need to updates those submodules too

    ```bash
    $ cd modules/purifier
    $ git submodule update --init 
    ```
    
    After this, make the directories
    ```library/DefinitionCache/Serializer``` in
    ```MODPATH/purifier/vendor/htmlpurifier``` writable by the web
    server.
    
    For more info check the
    [purifier module repo](https://github.com/shadowhand/purifier#readme)
    
#### Application Config

Open the file application/bootstrap.php and find `Kohana::init`,
  
Change the value of base_url to the one you would be using.
  
#### Database && Database Config

Create a new Mysql database and import the database schema and dump
provided in the _database.sql_ file in the kodelearn directory.

Copy the contents of the file _application/config/sample-database.php_
to a new file _database.php_ in the same directory and modify the
'default' configuration in it to add your database details.

Make sure you are copying the file to a new file and not
renaming. Renaming will work too but it will make the git repo dirty.
  
#### Writable Files and Directories
 
  Give write permissions to following directories
  
  - application/cache/
  - application/logs/
  - media/image/data/cache/
  
#### Change .htaccess file if required

Depending upon where you install kodelearn inside the document root of
your localhost or virtual host, the ```.htaccess``` file will have
to be modified.

for eg. If your base_url (the one you entered in bootstrap.php) is of
the form ```http://myvirtualhost.com/``` then there is no need to change
.htaccess file. If however, the base_url is of the form ```http://localhost/kodelearn/```
then change the RewriteBase directory in .htaccess as follows

```
RewriteBase /kodelearn/
```
  
#### It's done!!

Open the base_url in the browser. 

Following admin account is already there for you to get started
quickly -

email: admin.demo@kodelearn.com 
password: kodelearn 

After loggin in, change the email and password as per your
convenience.

# Kodelearn uses the Kohana PHP Framework, version 3.1 (release)

# Contributing to Kodelearn

If you think you can help us make this project better, feel free to do
so.

You may contribute by either reporting a bug (by the way of opening an
issue here on github) or may contribute directly by forking this
project and sending pull request.

We fairly follow
[this](http://nvie.com/posts/a-successful-git-branching-model/) git
branching model so the master branch is always stable and there is a
develop branch for any new development.

