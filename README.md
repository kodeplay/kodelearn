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
  * Download the stable source code from [Kodelearn website](http://kodelearn.com/download)
  
  * Or clone from github
    
    ```bash 
    $ git clone git@github.com:kodeplay/kodelearn.git
    ```
    
    You will also need to update the submodules by running the command
  
    ```bash
    $ cd kodelearn
    $ git submodule init
    $ git submodule update
    ```
    
#### Application Config

Open the file application/bootstrap.php and find `Kohana::init`,
  
Change the value of base_url to the one you would be using.
  
#### Database && Database Config

Create a new Mysql database and import the database schema and dump provided in the _database.sql_ file in the kodelearn directory.

Copy the contents of the file _application/config/sample-database.php_ to a new file _database.php_
in the same directory and modify the 'default' configuration in it to add your database details.
  
#### Writable Files and Directories
 
  Give write permissions to following directories
  
  - application/cache/
  - application/logs/
  - media/image/data/cache/
  
#### It's done!!

Open the project url in the browser. 

Following admin account is already there for you to get started quickly -

email: admin.demo@kodelearn.com
password: kodeplay2010

After loggin in, change the email and password as per your convenience.

# Kodelearn uses the Kohana PHP Framework, version 3.1 (release)

This is the current release version of [Kohana](http://kohanaframework.org/).
