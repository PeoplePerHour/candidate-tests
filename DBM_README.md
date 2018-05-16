
ABOUT THIS DB MANAGER
This is a simple connection manager using php's PDO class. 
It's framework agnostic and PHP >=7 compatible.
In order to support an abstract architecture the DB connection, CRUD actions and the where clause can all be customized by the user.

ABOUT THE FILES
- pph_db_test.sql
Is a the Create Syntax to create a simple USERS table with 3 rows for testing the application

- index.php
This script uses the database.php. 
In here a new connection is created. The user can change the table and can perform CRUD actions. 
Syntax of the actions will be discussed later on.

- database.php
This contains the class Database that implements all the logic and actions of this database manager.



DONE FEATURES
- Connect to a database 
In index.php user can change the following [db_driver, charset, host, db, user, pass]

- Provide methods for every of the CRUD operations (insert, update, delete, select)
[some examples can be found within index.php]

Insert... 
Input a multidimentional associative array in order to insert multiple rows or just an associative array if he wants to insert only a single row

Update...
Input an associative array setting as keys the names of the columns to be updated and value the new value. You may pass an associative array in order to build a where clause.

Delete...
You may pass an associative array in order to build a where clause

Select...
Select all the columns or just a number of them. You may pass an associative array in order to build a where clause.

WHERE clause...
Find below the supported conditions but check database.php getWhereComparison() in order to find the matching conditions.
[ =, !=, like, not like, in, not in, is null, is not null, >, <, >=, <= ]

- Eliminating SQL injection
SQL injection is handled using PDO's prepare statements and placeholders/questionmarks to bind the values

- Supports database transactions, if available by the RDBMS.
I use PDO's transaction related functions for this purpose. I begin and close transactions when INSERT, UPDATE, DELETE actions run and rollback any changes in case an exception occurs. PDO handles the fact that transaction may not be supported.

- Query caching
I have created a prepare function that overrides PDO's prepare(); While index.php is running all the queries that have run are saved in a private declared array. If the same query is requested then the cached in the array query execute instead of prepared and executing a new one.

- Data validation
Checks are made within database.php in order to handle empty values and arrays. I feed PDO's execute() with an array of values and use "?" in order to build and execute the query.
The DB is responsible to check what type of data is about to be inserted/updated with the columns of the table. Exceptions are thrown in non validated cases.



NOT DONE FEATURES
- Pagination handling
- Unit testing