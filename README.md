Alternative Gaming Australia
======

AG is an alternative-friendly online community. The new super awesome place to check out our servers, events, blog, maps and more.. all intergrated and sexy.


See the setup thingy below, this will be improved when its not just after midnight.. 


## Setup

#### Defaults:


- **IP Address**: 192.168.56.101
- **VirtualHost**: alternative-gamers.dev


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

Vagrant took care of everything, all you need to do is add `192.168.56.101 alternative-gamers.dev` to your hosts file.

### 7. Accessing MySQL & Importing the Database

*PhpMyAdmin is not installed by default.*

The database can be configured within vagrant normally with mysql, I prefer to use Sequel Pro from my host computer, you can download the connection file below to import.

- **Database**: `ag`
- **Username**: `root`
- **Password**: `password`

**Sequal Pro Connection Plist:** - <https://gist.github.com/nicekiwi/7511852>.

A dump of the database structure and some sample data can be downloaded here: <https://gist.github.com/nicekiwi/7512069>.

Migrations to handle the database do not exist as of yet.



### 8. Install Laravel dependancies

Once you have the code you'll need to install all the dependancies for the site, this is simple; just run `composer update` from the root directory.

## Fill in the Gaps

So there is some stuff missing, like the keys for all the secret stuff like Stripe payments and Amazon Web Services. As we're just deving for now you can sign up for and use your own.

- Stripe.com
- MailChimp THIng
- Amazon Web Services (This you might need mine for.. )

One you got the keys, drop them into `/app/config/keys.php`.

### Got an Issue?

File a new issue, b00m!.

