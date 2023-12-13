# PHP RESTful API Demo

This project is a small demonstration of how I would create a series of REST APIs using PHP and MySQL without using frameworks.

It also takes into account a question asked during the interview I had with Kumar, which was how would I connect two databases using PDO.

To be honest, I didn't understand if the question referred to two databases in the same schema, in the same docker service, or if they were two databases in different services.

Just in case, I made both types of connections, and therefore used three databases.

This project is not intended to be an extensive and complete example of how I would implement APIs, but rather just a small demonstration of the type of problem I could solve using PHP.

Of course, in a real case, I would implement some kind of authentication and would have much more tables, relations and business rules to take into account.

I already had this project, which originally demonstrated the use of Docker with PHP and MySQL, but as it had been a few years since I had worked on it, after the conversation with Kumar I decided to make some small improvements.

## Third party code

The only portion of code that comes from third parties is the class that creates the routes, whose official repository is: https://github.com/steampixel/simplePHPRouter

## Running

To run the APIs, you must have Docker and Docker-Compose installed, and then simply get the containers up with:

~~~
docker-compose up -d
~~~

## Testint the APIs

In the **/test** folder there are three files:

~~~
/test/cart.http
/test/location.http
/test/user.http
~~~

Each file has the endpoints to test the APIs for a specific domain (users, locations and carts).

I tested them using the Visual Studio Code REST Client extension, but any software that sends an HTTP call should work.

## Tables and databases

The tables used for each of these domains are in different databases, and they are accessible through PHPMyAdmin, which is available at http://localhost:8001

The configuration of the two MySQL services is already being taken to PHPMyAdmin, just select the desired port and use the "root" user without a password, or the "dbuser" user with the "secret" password.

## PDO and dependancy injection

The logic of using three PDO instances, loading and binding the containers for dependancy injection is being done at the **/bootstrap.php** file.

Starting from route identification to result return, the execution flow is:

        Route ➔ Controller ➔ Service ➔ Repository

If there are any problems along this path, an error result will be sent.

## Conclusion

I hope this shows a little of my problem resolution skills, and the way I write code.

Although the code has only a few comments, I believe it is clear enough to be understood, but if you have any questions, feel free to contact me at rogeriomendes@gmail.com

Thank you for your time!