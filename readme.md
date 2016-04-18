# Twitter-like project
I added source files so that you could look at the code I wrote.
Note: some part of the project is built without proper OOP approach to present how more difficult is to manage a project in non-structured way.

## How did I do it as high-level step by step process?

1. Create git repository and connect with Github account.
2. Drow all databases required for the project.
3. Create databases with references using MySQL Admin Panel.
4. Create classes with atributes and methods.
5. Download bootstrap.
6. Create all required pages with Boostrap's CSS styles.

### Quick tips&tricks in resolving some design approaches.
* checking in User's database if an email exists - you may want to use a solution where row with emails has UNIQUE property. This way, you can create if statment that checks error from mysqli - in short, "if $conn->errno == 1062", return "email already exists".
* user not found - you can use if statment after sending a mysqli query getting user's details with following logic statment: 'if num_rows == 0 (nothing returned = no user), return 'User not found'. Isn't that simple and strightforward?
* keep user logged in - you can set a SESSION = $user. This way, you can have a logic statment 'if SESSION set, the user is 'user A, if SESSION not set, go to login page'. Pro tip - remember about unsetting 'password'(nd other secret details) from the SESSION!
* use set/get approach for classes - it will make your life easier when you need to drow user's details on a website.
* create empty construct in each class - it will allow you to create very nice approach: firstly, create empty object, add userId from SESSION, load user's details from DB, change the details and save to DB again. This way you do not hold the object all the time - you have up-to-date details in your DB.
* create single include.php file - add all classes and connection to the file. This way, you will manage only one file if you create additional class to the project.
* use static methods to load data from databases, e.g. all tweets or all comments. It is easier to manage once you have all building blocks.

### Databases
I created following databases:
* users of the service,
* users' tweets with appropriate associations,
* users' comments with appropriate associations,
* messages with association to Users table (sender_id and receiver_id).

### Tools
I used following tools:
* php http://php.net/downloads.php
* MySQL https://www.mysql.com/downloads/
* VirtualBox https://www.virtualbox.org/
* Bootstrap http://getbootstrap.com/
* PHP Storm https://www.jetbrains.com/phpstorm/
* Atom https://atom.io/
* Git Bash https://git-for-windows.github.io/
* github https://github.com/
