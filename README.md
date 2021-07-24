1. Created a new laravel 

##
2. Run the composer require laravel/passport - This command creates the necessary files for using Passport including Controllers,Models,routes,migrations etc
3. Have to add last name and first name in Users migration then run migrate to create the DB.
3. Install passport so that keys are generated. Use --force if necessary

##
4. Set up environment variables for DB name, passowrd etc.
5. Create Models for Product, Category along with their migrations and resource Controllers.
6. Run the migrations so that tables are created.

##
7.  Set up Registration and Login code, make changes in Controller, Models, api.php as required.

##
8. Set up resource routing inside middleware auth.api group so that authentication is done using passport.
9. Create CRUD apis for categories and products according to laravel convention methods.

##
10. Initialize git on the project
11. Commit to git using bash

Note: I was getting an issue here where it was committing to master branch, so had to upload the files directly instead of committing via bash. 
