# Overview
I came accross http://www.phpbench.com/. Is it worth trying to use [PHPUnit](https://phpunit.de/) to organise and run a collection of PHP timing tests? I'm asuming it is. The advantage is a common framework for and organisation of tests. This repo is that.

Sample output [here](https://sgpinkus.github.io/PhpSpeedTests/).

# Requirements

  * php >= 5.4.0
  * phpunit >= 4.2

# Usage

    cd PhpSpeedTests/
    composer install
    phpunit
    firefox index.html

# Design Notes
Each test needs to report start and end time. Could use a phpunit listener but thats probably too innaccurate. Instead tests can optionally explicitly call methods to start and end time, otherwise we just use the time PHPUnit says they started and ended.
