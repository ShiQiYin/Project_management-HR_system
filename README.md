<<<<<<< HEAD
# Project_management-HR_system
=======
## Pre-requisite 

Make sure you have the following tools installed.
1. Docker
2. Git
3. MySQL Workbench (recommended)

---

## Application

Use the `./script/app` helper script to interact with the application.  
Create an alias to conveniently call the helper script.

```
alias app='bash script/app
```

To start up the application, run the command below.  
This command automatically installs the dependencies and start up the application container.  

```
app up
```

---

## Database Setup (Route 1: Container)

If you choose to run MySQL in a container, follow the steps below to initialize the database services.

1. Retrieve the system-generated database password for <strong>root</strong> from the MySQL container log.
2. Connect to the database.
3. Change the default password of <strong>root</strong>.
4. Restart the application -- run `app down`, followed by `app up`.

---

## Database Setup (Route 2: Local Installation)

If you choose to install MySQL locally, run the commands below after the installation.

```
CREATE SCHEMA bhm_app;

CREATE USER bhm_app_user@'%' IDENTIFIED WITH mysql_native_password BY 'password';

GRANT ALL PRIVILEGES ON bhm_app.* TO bhm_app_user@'%';
```

Update the following configurations in the `.env` file:

- DB_CONTAINER=false
- DB_HOST=host.docker.internal -- if the database is installed in the same host

---

## API References
1. Faker API https://github.com/fzaninotto/Faker
2. Laravel API https://laravel.com/api/9.x/

---

## Useful Debugging Tools:
1. Clockwork https://github.com/itsgoingd/clockwork
>>>>>>> 8d35e70a (init)
