Expense Date Calculator
=======================

Introduction
------------
- The normal base salaries are paid on the last day of the month unless
that day is a Saturday or a Sunday (weekend).
- On the 1st and 15th of each month the expenses are paid for the
previous fortnight, unless those days are on a weekend, in which case
they are paid on the first Monday after that date.

Installation
------------

Using Composer (recommended)
----------------------------
The recommended way to get a working copy of this project is to clone the repository
and manually invoke `composer` using the shipped `composer.phar`:

    cd my/project/dir
    cd salarypaydates
    php composer.phar self-update
    php composer.phar install

Web Server Setup
----------------

### Apache Setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

    <VirtualHost *:80>
        ServerName salarypaydates.local
        DocumentRoot /path/to/salarypaydates/public
        SetEnv APPLICATION_ENV "development"
        <Directory /path/to/salarypaydates/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>
