# PAC 12 Challenge Website

Official repository for the PAC 12 Challenge
[website](https://pac12challenge.org/) using the
[Laravel](https://laravel.com/) PHP framework

IMPORTANT: This repo is no longer under development and has been archived.

## Setting up a Development Environment

Requires [PHP](https://php.net) (5.6+), [Composer](https://getcomposer.org/),
[Vagrant](https://www.vagrantup.com/) (1.7.4+), and [Virtualbox](https://virtualbox.org)

1. Install dependencies with Composer using the command `php composer.phar install`
2. Install the Laravel Homestead Vagrant box using the command
   `vagrant box add laravel/homestead`
3. Generate `Homestead.yaml` (`php vendor/bin/homestead make` on Mac/Linux,
   `vendor\\bin\\homestead make` on Windows)
4. Edit `.env` and set `APP_KEY` to a value that's 32 bytes long (since this
   is for development only, it could be any 32 ASCII characters). For useful
   debugging info when something goes wrong, also set `APP_DEBUG` to `true`
5. Run `vagrant up` to start the Vagrant box
6. In order to build and seed the database, type `vagrant ssh` to SSH into the
   Vagrant box, then `cd pac12` and `php artisan migrate:refresh --seed` to
   run the database migrations and seed the database

You can now access the app in a web browser at the address
`http://localhost:8000/`.
