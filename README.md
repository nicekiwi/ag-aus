Alternative Gaming Australia
======

AG is an alternative-friendly online community. The new super awesome place to check out our servers, events, blog, maps and more.. all intergrated and sexy.


See the setup thingy below, this will be improved when its not just after midnight.. 


## Setup

#### Defaults:


- **IP Address**: 192.168.56.101
- **VirtualHost**: alternative-gaming.dev


### 1. Install Vagrant (Recommended) 

While you don't **have** to use Vagrant, I highly recommend you do; so we're all running in the same server enviroment. Vagrant uses VirtualBox as a provider for its VirtualMachines. You can download them both below:

- **Vagrant 1.3.x ** - <http://downloads.vagrantup.com>
- **VirtualBox 4.3.x ** - <https://www.virtualbox.org/wiki/Downloads>


### 2. Grab the Code

Clone the repository onto your harddrive where you can read write to it:

`git clone git@github.com:nicekiwi/alternative-gamers-au.git`


### 4. Setup Vagrant Box

Go into the `/vagrant` directory and run `vagrant up` in console. This will download the VirtualBox image and configure the VM specific to this application. 

In this case we are using:

- Ubuntu 12.04 64bit (300Mb~)
- Nginx, PHP 5.4, MySQL 5.5
- Composer
- xDebug

A VirtualHost (ServerBlock) will be created automatically.

### 5. Access Vagrant

Once thats done your dev server is setup, simple right? Non of this Wamp/Xampp/Mamp nonsense. :)

Accessing your vagrant server like so, from the `/vagrant` directory run `vagrant ssh`. and b00m! You're in!


### 6. Setup Virtual Host

Vagrant took care of everything, all you need to do is add `192.168.56.101 alternative-gaming.dev` to your hosts file on your host computer *(Not in the VM)*.


### 7. Install Laravel dependancies

Once you have the code you'll need to install all the dependancies for the site, this is simple; just run `composer update` from the root directory.


### 8. Accessing MySQL & Importing the Database

*PhpMyAdmin is not installed by default.*

Create the database in console: `mysql -u root -p -e "create database ag";`

- **Database**: `ag`
- **Username**: `root`
- **Password**: `password`

Migrations and Data Seeding are now included. Run `php artisan migrate --seed` to setup the stuff.


## Fill in the Gaps

So there is some stuff missing, like the keys for all the secret stuff like Stripe payments and Amazon Web Services. As we're just deving for now you can sign up for and use your own.

- Stripe.com
- Mandrill SMTP
- Amazon Web Services (You'll need to get a key to Sync maps)

One you got the keys, drop them into `/app/config/keys.php`.

**Sequal Pro Connection Plist:** - <https://gist.github.com/nicekiwi/7511852>.

### Got an Issue?

File a new issue, b00m!.

