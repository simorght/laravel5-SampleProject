## Laravel 5 example ##

**Laravel 5 example** is a tutorial application (in farsi).

### Installation ###

* `git clone simorght/laravel5-SampleProject.git projectname`
* `cd projectname`
* `composer install`
* `php artisan key:generate`
* Create a database and inform *.env*
* `php artisan migrate --seed` to create and populate tables
* `php artisan vendor:publish` to publish filemanager

### Include ###

* [HTML5 Boilerplate](http://html5boilerplate.com) for front architecture
* [Bootstrap](http://getbootstrap.com) for CSS and jQuery plugins
* [jQuery](http://jquery.com) jQuery plugins (validation , fallr , ...)
* [Startbootstrap](http://startbootstrap.com) for the free templates
* [CKEditor](http://ckeditor.com) the great editor
* [Filemanager](https://github.com/simogeo/Filemanager) the easy file manager

### Features ###

* Home page
* Custom Error Page 404,503.403
* Authentication (registration, login, logout, password reset, mail confirmation, throttle)
* Users roles : administrator (all access), redactor (create and edit post, upload and use medias in personnal directory), and user (create comment in blog)
* Blog with comments
* Search in posts
* Admin dashboard with  posts and comments
* Users admin (roles filter, show, edit, delete, create)
* Messages admin
* Posts admin (list with dynamic order, show, edit, delete, create)
* Medias gestion

* Repository Structure

### Packages included ###

* laravelcollective/html

### Tricks ###

To test application the database is seeding with users :

* Administrator : email = soltanzad@engineer.com or username = samad , password = admin
