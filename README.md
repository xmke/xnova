# Welcome to XNova !
Hi! XNova is an Open Source project clone of the original space game, OGame.

This project is an old project, which is currently being updated and gradually rewritten. The main goal is to correct bugs, optimize the game and make it more reliable.

Game development is slow, as I do this in my spare time.

Feel free to contribute and comment :)

## Prerequisites

 - A server running Linux or Windows
 - PHP >= 7.1
 - MySQL or MariaDB
 - Apache2 or ngix webserver
 ... and that's all !

## Local development/setup
To setup a local development environment follow the next steps:
1. Create database and user and grant database access rights for the user. Remind the credentials as they are needed with for the game installation
2. Install dependencies using composer by running ``composer install``
3. Run a local webserver from CLI: ``php -S 127.0.0.1:8000 -t .``
4. Open a webbrowser and visit `127.0.0.1:8000`
5. Follow the game installation steps
6. Login and enjoy

 ## Project status
 **UNSTABLE** - may contain bugs, may be slow... W.I.P !
 
 ## Next project steps
 - Rewrite of the Galaxy view
 - Rewriting of alliances
 - Rewrite of the management of points and their calculation
 And many more ! 

 ## Used projects
  - [Mustache Template Engine](https://github.com/bobthecow/mustache.php) by [bobthecow](https://github.com/bobthecow)
  - [jenstornell](https://github.com/jenstornell)'s [Tiny HTML Minifier](https://github.com/jenstornell/tiny-html-minifier)
  - OGame [classic skin](https://github.com/Caffe1neAdd1ct/ogame-origin-epic-blue) hosted by [Caffe1neAdd1ct](https://github.com/Caffe1neAdd1ct/)
  
**Thank you guys !** 
