Project AddRest
===============

The simplest (was-to-be) RESTful application for practicing coding skills.

Started up as a technical test for a job interview, the main requirement being not using frameworks or libraries; then I decided
to put it up on GitHub, making it public.

Feel free to use any ideas or bits and pieces from this code, I'm also open
for suggestions how I could make it simpler, better, etc.

This is definitely a work in progress.

[tilted, rusty, hand-painted sign] ENTER AT YOUR OWN RISK!

Requirements
------------

- PHP v5.5, or newer
- SQLite 3 PHP extension
- Composer
- XDebug PHP extension for test coverage generation and some minor tests

Usage
-----

First, you have to run composer to set up autoloading and QA tools:

    $ composer install

Run the built-in PHP web server with the script provided:

    $ bin/runserver.sh

Open the app in your web browser with an ID number between 0 and 3, e.g.:

[http://localhost:8080/index.php/address?id=2](http://localhost:8080/index.php/address?id=2)

Or, use the app with an optional API version included:

[http://localhost:8080/index.php/v1/address?id=3](http://localhost:8080/index.php/v1/address?id=3)

With PHP's built in webservice, it's possible to omit the PHP script name
from the url:

[http://localhost:8080/v1/address?id=3](http://localhost:8080/v1/address?id=3)

Testing
-------

Run the tests included by running the script provided:

    $ bin/runtests.sh

QA for the source code
----------------------

Run the source QA tools by running the script provided:

    $ bin/runqatools.sh
