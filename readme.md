# PAC 12 Challenge Website

Official repository for the PAC 12 Challenge
[website](https://pac12challenge.org/) using the
[Laravel](https://laravel.com/) PHP framework

## Setting up a Development Environment

Requires [PHP](https://php.net), [Composer](https://getcomposer.org/),
[Vagrant](https://www.vagrantup.com/), and [Virtualbox](https://virtualbox.org)

1. Install dependencies with Composer using the command `composer install`
2. Install the Laravel Homestead Vagrant box using the command
   `vagrant box add laravel/homestead`
3. Generate `Homestead.yaml` (`php vendor/bin/homestead make` on Mac/Linux,
   `vendor\\bin\\homestead make` on Windows)
4. Edit `.env` and set `APP_KEY` to a value that's 32 bytes long (since this
   is for development only, it could be any 32 ASCII characters). For useful
   debugging info when something goes wrong, also set `APP_DEBUG` to `true`
5. Run `vagrant up` to start the Vagrant box

You can now access the app via SSH with `vagrant ssh` or in a web browser at
the address `http://localhost:8000/`.
