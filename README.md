# L2-S3_ProjetBIN5WAVE_BDD

Project for "Base de données" in 2nd year of Computer Science at Université Gustave Eiffel.
This project consisted in creating a PostgreSQL database that can store data similar to what a basic online music streaming service would have.

The project was cut in 3 parts :
- Database design
- Creating the database and filling it with data
- Creating a basic website with php to communicate with the database

## Importing the database

You can import the database with the SQL Dump located in the root directory. Make sure your server is running PostgreSQL as our work was based on it.

## Using the website

You need to edit the `connection.inc.php` file (in the `Site Php` directory) to fit your own database.

The necessary modifications are the username and password variables for the database in the 2nd and 3rd line, and also the database address and database name in the 7th line.

## Basic documentation

The project reports written in french are available in the `doc` directory, the projet instructions are located in the `Sujet` subdirectory.
