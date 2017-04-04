# Recorder

Recorder is an application to record users through owncloud and implement a database with NZ english and Maori languages.

## Installation

Download the recorder repository and place this in **owncloud/apps/**

Attention : The name of the repository HAVE TO be recorder !!

## Publish to App Store

First get an account for the [App Store](http://apps.owncloud.com/) then run:

    make appstore_package

The archive is located in build/artifacts/appstore and can then be uploaded to the App Store.

## Running tests
After [Installing PHPUnit](http://phpunit.de/getting-started.html) run:

    phpunit -c phpunit.xml
    
## More 

To have more informations on how you can manage this application, let's see the [Owncloud Developer Manual](https://doc.owncloud.org/server/latest/developer_manual/app/index.html)...

If you are in trouble with the interface, you can find some help [here](https://www.w3schools.com/html/default.asp) !
