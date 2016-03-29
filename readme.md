# Twitter-like project

## How did I do it as high-level step by step process?

1. Create git repository and connect with my Github account.
2. Create databases using MySQL Admin Panel.
3. Download bootstrap.
4. Create all required pages: index, login, register and many more.

## What went wrong?
I will add here issues I had during the project.

### What went well?
I will add here parts that went smooth and easy.

### Quick tips&tricks in resolving some design approaches.
* checking in User's database if an email exists - you may want to use a solution where row with emails has UNIQUE property. This way, you can create if statment that checks error from mysqli - in short, "if $conn->errno == 1062, return "email already exists".
* user not found - you can use if statment after sending a mysqli query getting user's details with following logic statment: 'if num_rows == 0 (nothing returned = no user), return 'User not found'. Isn't that simple and strightforward?
* keep user logged in - you can set a SESSION with as a $user. This way, you can have a logic statment 'if SESSION set, user 'user'. Pro tip - remember about unsetting 'password' from the SESSION!

### Databases
I created following databases:
* users of the service,


### Front end
I have used JavaScript and Bootstrap as a front end client with following websites:
* index.php
* registration.php
* login.php


### Back end
* php
* MySQL



Opisz jaka jest różnica pomiędzy:
* ```require``` a ```include```,
* ```require``` a ```require_once```.

## Zadanie praktyczne
Kod wpisz w odpowiednim pliku.


<!-- Links -->
[forking]: https://guides.github.com/activities/forking/
[ref-clone]: http://gitref.org/creating/#clone
[ref-commit]: http://gitref.org/basic/#commit
[ref-push]: http://gitref.org/remotes/#push
[ref-rand]: http://php.net/manual/pl/function.rand.php
[pull-request]: https://help.github.com/articles/creating-a-pull-request
