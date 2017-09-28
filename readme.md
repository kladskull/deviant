<p align="center">PSW - PHP Secure Framework</p>

## About PSW
The name WILL change, but until something strikes me, this is
the working name. PSW is a PHP framework that is has been designed 
from the ground up in the hopes of becoming one of the most security
aware frameworks. Some of the ideas and design come from
a Bitcoin Exchange I was part of that had to be as secure as 
possible.

## PSW Sponsors
We would love to become sponsored for helping fund the development of this
project. If you or your company is interested, please contact 
mikecurry74@gmail.com

## What to Expect
Because this is a new open source project, expect that it
is not mature enough to be used in any production environment.
Also expect that it is not as secure as it is to become. You'll
also notice that there is not a lot of commenting or documentation.
I aim to resolve all of this, as well as encapsulate some of the 
code in objects, and use some proper design methodologies. I'm
also leaning a bit on the community to help me during this process
as I am not happy with some of the code structure.

## Installation
Ensure that you have composer installed, clone the repository, and
do a composer install. All of your templates go in 
/app/templates/ and all of your pages go into /app/scripts. Currently
we only support Smarty. Once we become more mature, we'll be deciding
on a template library, or adding the ability to use others.

You will also need to copy `/env_example` to `/.env` and modify the 
contents to your server configuration. 

Any helper libraries you create can reside in /app/. Be sure to add the
includes to /app/config/includes.php. Also note table names are defined
as const variables in /app/config/database.php. The idea behind this is
to be better ready for hot migrations going forward.

The schema can be found in /app/database/ - run it on your MySQL Database.

You should run `/fix_perms.sh` after any modifications to the code on
your server.

You should add the following to an .htaccess file in the root, or better
inside your apache configuration.

~~~~
RewriteEngine On
RewriteBase /
RewriteRule ^(.*)/$ /$1 [L,R=301]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ /index.php [L,QSA]
~~~~

## Post Installation
Visit yoursite.com/register - this will allow you to become an 
administrator. Further registration will have to be done from 
yoursite.com/signup. Currently any sign-ups have to be approved
by the administrator. This will be a config option going forward,
but for now, its just the way it is.

## Learning PSW
Initially, its going to be a little more difficult than you'd hope
for, as there is no documentation. If you're looking to contribute 
to something on the ground floor, this is your time to shine!

## Unit Tests
This is a very big priority for me, and I will be starting them
as I convert things over to objects.

## Documentation
See above 'Learning PSW'

## Contributing
Thank-you for considering this. There have been no guides created 
as of yet, but if you're serious, please email me at 
mikecurry74@gmail.com (or just start contributing!)

As you can see, the code is pretty `ok` but not anything close
to what it should be, why not pitch in?

## Security Vulnerabilities
If you discover a security vulnerability within PSW, please send 
an e-mail to Mike Curry at mikecurry74@gmail.com. All security 
vulnerabilities will be promptly addressed.

## Responsibility
You are responsible for your website, and take all risk using this
framework. We will not be held responsible for any breaches or
lack of security functionality coming out of the use of this framework,
even if we know of such vulnerability. Everything is risky in WWW!

## License
The PSW is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
