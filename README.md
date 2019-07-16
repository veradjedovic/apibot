# Apibot
## Installation
- Clone or download the project.
- Project was built with Laravel 5.8 framework for PHP.
- Do composer install.
- Create a database.
- Set the .env file.
- Run migrations with the command from the command line: <strong> php artisan migrate </strong>
- Run seeds with the command from the command line: <strong> php artisan db:seed </strong>
- Create a virtual host. 
- Run the command from the command line: <strong> php artisan bot:start </strong>. This is a custom command that I created and that command presents the bot that is able to use the API with <strong>rest</strong> or <strong>soap</strong>.
- After starting the command, you can choose the <strong>rest</strong> or <strong>soap</strong> mode (<strong>soap</strong> is default). 
- If you choose the <strong>soap</strong> mode, api/soap route will be called. 
- If you choose the <strong>rest</strong> mode, you have to log in with right credentials if you want to continue operation.
- After log in, all of api/customers and api/orders route will be called.
- You can see how the code is executed in the command line.
- Also, the bot logs all operation. You can take a look in the log file and you can see that. The log file placed in the storage/logs folder.
