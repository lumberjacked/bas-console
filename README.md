# BasConsole for Zend Framework 2

Master: [![Build Status](https://secure.travis-ci.org/lumberjacked/bas-console.png?branch=master)](http://travis-ci.org/lumberjacked/bas-console)
Dev: [![Build Status](https://secure.travis-ci.org/lumberjacked/bas-console.png?branch=dev)](http://travis-ci.org/lumberjacked/bas-console)

BasConsole uses Symfony Console to generate Zend Framework 2 files, configs,
and scalffolding for your zf2 project. 

  - generate:app
  - generate:module
  - route:add
  - route:update
  - route:delete

## Requirements
Dependencies are setup in the composer.json file.  Currently Composer is the only supported method for requiring dependencies.

## Installation

Composer installs all the depdencies, everything is defined in composer.json. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

#### Installation steps

  - `cd my/project/directory`
  - `git clone https://github.com/lumberjacked/BasConsole.git`
  - run `php composer.phar install`
  - alias the project for easy access `alias zf2='~/workspace/BasConsole/console'`

#### Full configuration options

For a list of all available commands 

 * zf2 --help
 * zf2 command:name --help (For specific help on a command)

## Usage

 * Read the output of the commands is the easiest way.

#### Coming Soon

 * More Commands to be able to do a viarity of things from the command line.
 



