# DnEye

DnEye is a portal for for movie, TV and celebrity content. Its peculiarity is that It does not require human intervention to populate its database: if a user searches for an item that does not exist in the system, dneye automatically query services like imdb, and will automatically update the system.

This project was born as an experiment to understand the logic of the Symfony framework 3.1.3. I will keep This repository updated for I experimenting  new bundles or for  making the site and the user experience the best it can be

# Requirements
>web server(eheh)

>[MongoDb](https://www.mongodb.com)

>[Gearman Job server](http://gearman.org/)

# Install
Dneye require  [Composer](https://getcomposer.org/) for installing

All dependencies are placed in composer.json. Just run
```
composer install
```
in **root** directory

# Note
This site is still an alpha and is longer to be considered finished. There are so many bugs and errors so don't put it online(or do on your own risk)

# Bundle used
    - DoctrineMongoDBBundle
    - GearmanBundle
    - FOSUserBundle
    - FOSCommentBundle
    - AsseticBundle
    
# Already discovered bugs but still not fixed
   - in SearchController, the method dobBackgroundJob will launch and exception and return
   - Comment posting give a 404 error

# Todo for the future
  - Integrating comment on episode page
  - Implement themoviedb and .. API
  - Create a job that keep updated the already present item on dneye db


