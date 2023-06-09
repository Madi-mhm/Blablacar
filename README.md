# Symfony Project README

This README file provides instructions on setting up and running a Symfony project. It covers the necessary steps to install dependencies, initialize the database, and start the project.

## Prerequisites

Before starting, ensure that you have the following prerequisites installed on your system:

- PHP (recommended version: 7.4 or higher)
- Composer (https://getcomposer.org/)
- Node.js (https://nodejs.org/) and npm (Node Package Manager)

## Installation

Follow the steps below to set up and run the Symfony project:

1. Clone the repository from GitHub: 
```
git clone <repository-url>
```
2. Change into the project directory:
```
cd <project-directory>
```
3. Install PHP dependencies using Composer:
```
composer install
```
4. Initialize npm and install required packages:
```
npm init
npm install node-sass sass-loader --save-dev
```
5. Create the database using Doctrine:
```
php bin/console doctrine:database:create
```
6. Run database migrations to create the necessary tables:
```
php bin/console doctrine:migrations:migrate
```
7. (Optional) Load sample data/fixtures into the database:
```
php bin/console doctrine:fixtures:load
```

## Usage

To start the Symfony project, follow these steps:

1. Run the following command to start the Webpack Encore watcher:
```
npm run watch
```
This will compile your frontend assets (e.g., SCSS, JavaScript) automatically whenever changes are made.

2. In a separate terminal, start the Symfony server:
```
symfony server:start
```

The Symfony server will start serving your application locally.

3. Open your web browser and navigate to the specified URL (usually http://localhost:8000) to view and interact with the Symfony project.

## Additional Configuration

- Database configuration: If your database configuration differs from the default settings, update the `DATABASE_URL` parameter in the `.env` file.

- Symfony environment: By default, the project runs in the `dev` environment. To change this, set the `APP_ENV` parameter in the `.env` file to `prod` for production or any other desired environment.

- Server port: If port 8000 is already in use, you can specify a different port by running `symfony server:start --port=<port-number>`.

## Conclusion

You have successfully set up and started the Symfony project. Now you can begin developing your application. Refer to the Symfony documentation (https://symfony.com/doc) for further guidance on building Symfony applications.



