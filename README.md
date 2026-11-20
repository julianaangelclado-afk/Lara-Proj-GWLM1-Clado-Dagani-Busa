# BandIT – Music Studio Website

BandIT is a local-business website concept for a music rehearsal studio. It introduces the studio, shares its story and contact information, and gives visitors a way to start booking a rehearsal session.

## Group Information

| Detail | Information |
|---|---|
| **Group Name** | BandIT |
| **Section** | GWLM1 |
| **App Theme** | Local Business |

### Group Members and Assigned Modules

| Member | Assigned Module |
|---|---|
| **Juliana Clado** | Laravel Setup and Homepage |
| **Jasmin Dagani** | About Page |
| **Flora Busa** | Contact Page |

## Screenshots

### 1. Home Page – Laravel Setup and Homepage

![BandIT Home Page](screenshots/home.png)

### 2. About Page

![BandIT About Page](screenshots/about.png)

### 3. Contact Page

![BandIT Contact Page](screenshots/contact.png)

## Requirements

Before running the project, make sure you have installed:

- PHP (a version compatible with the Laravel version used by the project)
- Composer
- Laravel's required PHP extensions
- Node.js and npm (if the project uses Vite or other npm-managed frontend assets)
- A database supported and configured by the project, if database functionality is used

## Steps to Run the Project

1. **Open the project folder** in your terminal or code editor.

2. **Install PHP dependencies:**

   ```bash
   composer install
   ```

3. **Set up the environment file.** If the project does not yet have a `.env` file, copy the example file:

   ```bash
   cp .env.example .env
   ```

   On Windows Command Prompt, you can use:

   ```cmd
   copy .env.example .env
   ```

   If a `.env` file already exists, keep it and do not overwrite it.

4. **Generate the Laravel application key:**

   ```bash
   php artisan key:generate
   ```

5. **Configure the database, if required.** Open `.env` and set the database connection details to match your local setup. For example, configure `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` when using MySQL. Use the database type already expected by the project.

6. **Run database migrations, if the project includes migrations:**

   ```bash
   php artisan migrate
   ```

7. **Install and build frontend assets, if the project uses npm/Vite:**

   ```bash
   npm install
   npm run build
   ```

8. **Start the Laravel development server:**

   ```bash
   php artisan serve
   ```

9. **Open the local website** in your browser using the address shown in the terminal. The default Laravel address is:

   ```text
   http://127.0.0.1:8000
   ```

## Notes

- Run the commands from the root directory of the Laravel project (the folder containing `artisan` and `composer.json`).
- If the project does not use a database, steps 5–6 may be skipped.
- If the project uses Vite during development, you may need to run `npm run dev` in a second terminal while `php artisan serve` is running, instead of or in addition to building assets with `npm run build`.
- If an error occurs, check that your PHP version and required extensions match the Laravel version used by the project, and that your `.env` settings are correct.
