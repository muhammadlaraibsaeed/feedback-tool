# Ikonic Coding Challenge Solution 💻

Make sure your internet connection is active because I am using the Content Delivery Network (CDN) for Bootstrap and jQuery.

## Tech Stack for this Solution 🐘

-   Laravel 8.82, PHP 7.
-   Bootsrap 5
-   JQuery
-   MySQL

## Getting Started 🏃

-   Create a local copy of the repository.
-   Make sure you have xxamp or something similiar.
-   Create a database, name it 'laravel_ikionic'.
-   Setup .env file
-   Run `composer install` and `php artisan key:generate`.
-   When you see the login page, head over the register page, create an account and log in. After that you wil able to get comment on feedback .
-   You can utilize the database seeder by running the command `php artisan db:seed` to generate synthetic or test data for application.

## Objective ✅

Demo Video:

<!-- Website Flow -->

https://drive.google.com/file/d/1OOL6PhEboJQn603BkwT18dHqvHi_YcQj/view?usp=sharing

## Form Validation Rule

     [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'category' => 'required|integer',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
     ];

## Markdown Format

    use     **Bold text**
    use        *italic text*
    use    ```Block Code text```

## Notification Information Setting

-   I have set up Mailtrap to send notifications for comments, likes, or dislikes on feedback.
-   Please ensure that your email settings are correctly configured in the `.env` file.

<!-- Link For Mailtrap -->

https://mailtrap.io/home