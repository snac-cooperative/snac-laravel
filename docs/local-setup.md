# Local Setup

## DDEV

The SNAC Laravel application uses DDEV for local development.

Follow the [getting started guide](https://ddev.com/get-started/) to install DDEV on your machine.

### Running the server

Once DDEV is installed, run the following command in the root of this project.

```sh
ddev start
```

#### IMPORTANT
This application shares its database with the snac-server application and snac-server must be running and have an imported database before this application will work.

### Installing dependencies

Once the server is running, run the following command to install the dependecies with composer.

```sh
ddev composer install
```

### Setting up .env

Simply copy `.env.example` to `.env`

### Running migrations

Please note that this application shares its database with the snac-server application and snac-server must be running and have an imported database before running this command

```sh
ddev artisan migrate
```

### Stopping the server

Run the following command to stop your project.

```sh
ddev stop
```
