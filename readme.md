# Twitter-like project

## How did I do it as high-level step by step process?

1. Create git repository and connect with Github account.
2. Drow all databases required for the project.
3. Create databases with references using MySQL Admin Panel.
4. Create classes with atributes and methods.
5. Download bootstrap.
6. Create all required pages with Boostrap's CSS styles.

## What went wrong?
I will add here issues I had during the project.

### What went well?
I will add here parts that went smooth and easy.

### Quick tips&tricks in resolving some design approaches.
* checking in User's database if an email exists - you may want to use a solution where row with emails has UNIQUE property. This way, you can create if statment that checks error from mysqli - in short, "if $conn->errno == 1062", return "email already exists".
* user not found - you can use if statment after sending a mysqli query getting user's details with following logic statment: 'if num_rows == 0 (nothing returned = no user), return 'User not found'. Isn't that simple and strightforward?
* keep user logged in - you can set a SESSION = $user. This way, you can have a logic statment 'if SESSION set, the user is 'user A, if SESSION not set, go to login page'. Pro tip - remember about unsetting 'password'(nd other secret details) from the SESSION!
* use set/get approach for classes - it will make your life easier when you need to drow user's details on a website.
* create empty construct in each class - it will allow you to create very nice approach: firstly, create empty object, add userId from SESSION, load user's details from DB, change the details and save to DB again. This way you do not hold the object all the time - you have up-to-date details in your DB.
* create single include.php file - add all classes and connection to the file. This way, you will manage only one file if you create additional class to the project.
* use static methods to load data from databases, e.g. all twits or all comments. It is easier to manage once you have all building blocks.


### Databases
I created following databases:
* users of the service,
* users' twits,
* users' comments,
* messages with association to Users table (sender_id and receiver_id).

### Tools
* Bootstrap
* php
* MySQL
* PHP Storm
* Atom
* github

<!-- Links -->
[forking]: https://guides.github.com/activities/forking/
[ref-clone]: http://gitref.org/creating/#clone
[ref-commit]: http://gitref.org/basic/#commit
[ref-push]: http://gitref.org/remotes/#push
[ref-rand]: http://php.net/manual/pl/function.rand.php
[pull-request]: https://help.github.com/articles/creating-a-pull-request
