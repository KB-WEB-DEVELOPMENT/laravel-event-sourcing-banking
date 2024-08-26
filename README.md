# Laravel 10 event sourced banking application 

The goal of the project was to develop a php event sourced application using Laravel 10.

For inspiration, I used the following Python event sourced BankAccounts application:

https://eventsourcing.readthedocs.io/en/stable/topics/examples/bank-accounts.html#application  

Using Spatie laravel-event-sourcing package (https://spatie.be/index.php/docs/laravel-event-sourcing/v7/introduction), the following project building blocks were coded:

<b>1) Project events:</b>

AccountOpened, FundsDeposited, FundsWithdrawn, OverdraftLimitCreated, OverdraftLimitReached, FundsTransferred

<b>2) Project projectors:</b>

AccountProjector, TransferFundsProjector

<b>3) Project reactors:</b>

OfferLoanReactor

<b>4) Project aggregates:</b>

AccountAggregateRoot, TransferFundsAggregateRoot

! [alt text] 
(https://github.com/KB-WEB-DEVELOPMENT/laravel-event-sourcing-banking/blob/main/public/images/diagram.PNG)

<b>Installation steps:</b>

1) Clone the repository:

   (terminal command) git clone https://github.com/KB-WEB-DEVELOPMENT/laravel-event-sourcing-banking.git

2) Install composer dependencies: (terminal command) composer install

3) Copy the environment file ".env.example" and rename it ".env": (terminal command) cp .env.example .env

4) Generate a Laravel application key: (terminal command) php artisan key:generate

5) Configure the database: 

   Open the .env file in a text editor and configure your database settings. 

   You will need to set values for: 

   - DB_CONNECTION
   - DB_HOST
   - DB_PORT
   - DB_DATABASE
   - DB_USERNAME
   - DB_PASSWORD.

7) Migrate the database: (terminal command) php artisan migrate

8) Seed the database (Optional): (terminal command) php artisan db:seed --class=AccountSeeder

   This will create two bank customers (visible in the "users" database table) and 
   two bank accounts (visible in the "accounts" database table).

Customer 1
- name: debitor
- email: debitor@bank.com
- password: password 

Customer 2
- name: creditor
- email: creditor@bank.com
- password: password

Customer 1 bank account:
- id: 1
- account_uuid: 00643dd8-d888-4576-9839-9bef16e3cbda
- balance: 1999.99
- overdraft: (randomly generated integer between 0 and 200)
- user_id: 1

Customer 2 bank account:
- id: 2
- account_uuid: d5e161f1-3e47-4d77-985d-a05558efc9ba
- balance: (randomly generated 2 decimals float number between 1000.00 and 2000.00)
- overdraft: (randomly generated integer between 0 and 200)
- user_id: 2
 
You can also (optionally) simulate a bank funds transfer from Customer 1 bank account to Customer 2 bank account 
by running the following seeder (terminal command): 

php artisan db:seed --class=TransferFundSeeder

This will store a row entry in the database table "transfer_funds" with the following values:

- id: 1
- debitor_account_uuid: 00643dd8-d888-4576-9839-9bef16e3cbda
- creditor_account_uuid: d5e161f1-3e47-4d77-985d-a05558efc9ba
- amount: 49.99

Customer 1 bank account balance and Customer 2 bank account will be updated:

Updated customer 1 bank account:
- id: 1
- account_uuid: 00643dd8-d888-4576-9839-9bef16e3cbda
- (new) balance: 1950.00
- overdraft: (same as above)
- user_id: 1 
 
Updated customer 2 bank account:
- id: 2
- account_uuid: d5e161f1-3e47-4d77-985d-a05558efc9ba
- (new) balance: pre-transfer value + 49.99 
- overdraft: (same as above)
- user_id: 2

8) Install Node.js Dependencies (Optional): (terminal command) npm install # or yarn install

9) Compile JavaScript and CSS assets with Laravel Mix (Optional): (terminal command) npm run dev # or yarn dev

10) Start the Development Server: (terminal command) php artisan serve and visit http://localhost:8000
