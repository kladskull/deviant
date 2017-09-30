<p align="center">Deviant - Simple, Extensible Boilerplate/Mini-Framework</p>

## About Deviant
Deviant is a PHP Boilerplate/mini-framework that has been designed 
from the ground up to be quick and responsive.

## What to Expect
Because this is a newer project, expect that it may not be
mature enough to be used in a production environment.
You'll also notice the lack of documentation, which is being
worked on.

## Installation
Ensure that you have composer installed, clone the repository, and
do a composer install. All of your templates go in 
/app/templates/ and all of your pages go into /app/scripts. Currently
we only support Smarty. If you have any issues, take a loot at some of 
the base project, specifically `/app/controllers/login.php' and its template
'/app/templates/login.tpl'.

You will also need to copy `/env_example` to `/.env` and modify the 
contents to your server configuration. 

Be sure to add any includes to the bootstrap in `/app/bootstrap.php`. This
will defintely change going forward, so make sure to heavily comment.

The schema can be found in /app/database/ - run it on your MySQL Database.

If your permissions get messed up, you can always run 
`/fix_perms.sh`.

## Post Installation
Visit yoursite.com/signup - this will allow you to become an 
administrator. Any registrations that follow will have to be `unlocked`
in the administrator/users menu. Currently any sign-ups have to be approved
by the administrator. This will be a config option going forward,
but for now, its just the way it is.

## Contributing
Thank-you for considering this. There have been no guides created 
as of yet, but if you're serious, please email me at 
mikecurry74@gmail.com (or just start contributing!)

## Security Vulnerabilities
If you discover a security vulnerability within PSF, please send 
an e-mail to Mike Curry at mikecurry74@gmail.com. All security 
vulnerabilities will be promptly addressed.

## Responsibility
You are responsible for your website, and take all risk using this
framework. We will not be held responsible for any breaches or
lack of security functionality coming out of the use of this framework,
even if we know of such vulnerability. Everything is risky in WWW!

## License
Deviant is open-sourced software licensed under the 
[MIT license](http://opensource.org/licenses/MIT).
