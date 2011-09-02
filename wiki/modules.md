# 1. Extending Kodelearn

Kodelearn can be extended with the help of normal Kohana modules
that satisfy some additional requirements for seamless integration with
Kodelearn.

### 1.1 How to create a new module in kodelearn ?

Since Kodelearn uses Kohana, Kodelearn module is nothing but a Kohana module. 

* Create a module directory named <yourmodulename> inside kodelearn/modules

* Edit the application/bootstrap.php file to enable this kohana module

* Create a controller file  <modulename>/classes/controller/<modulename>.php . 
Name of the controller will be Controller_<ModuleName> as per the Kohana conventions

* Edit the roles for admin (and any other users) to set permissions to this module

(To change these access levels for your module refer to [section 1.3](#1.3))
  
Change it to allow some permission to atleast one user and the module will start working 
for that user.

* Congratulations, you have created your kodelearn module.

### 1.2 init.php file of your module
Just an in any Kohana module, the init.php file of this module will be loaded during bootstrap
along with the init.php files for all other enabled modules.

This is the file to perform additional setup for your module
such as, 

#### 1.2.1 Adding a menu link for this module
For the user to access your module, its important to provide a link to it in one (or more) of 
the menus in kodelearn.

In kodelearn we have 3 menus which can be referenced using following names

  - sidemenu - The vertical menu in the sidebar on the left side
  - topmenu - The horizontal menu in the black bar on top of the page
  - myaccount - The drop down menu that appears when clicked on My Account on top right of the page.
  
To add a menu link to your module in the sidemenu, add the following code in the init.php file of your module

``
DynamicMenu::extend(array(
    'sidemenu' => array(
        array('document', 'Documents', 5, array()),
    ),
)); 
``
  
Adding menu links for your module to the sidemenu and myaccount does not involve changing any views
while in case of topmenu you will need to modify the [application/views/template/header.php]() file.

`` code here ``

### 1.3 Custom ACL for your module
When you edited the user permissions for this module, it asked you to set permissions for 4 access levels

  - view
  - create
  - edit 
  - delete

These 4 are the default access levels which kodelearn will assume for all resources without specifying anything
explicitly.
To overwrite these with your own, create a new file 
/modules/<modulename>/config/acl.php and make it return an array indicating the Acl_Config class 
not to inherit default levels

``
return array(
    '<controllername>' => array(
        'inherit_default' => false,
        'levels' => array(
            'view',
            'upload',
            'download',
        ),
    ),
);
``

If you want to remove this controller from the user permissions list altogether, then add following lines

``
return array(
    ...
    'play' => array(
        'ignore' => true,
    ),
    ...
);``   

This will not show play in the user permissions page and all users will get access to it.
Then inside you may add your own logic to allow/disallow any particular user group from accessing it.
