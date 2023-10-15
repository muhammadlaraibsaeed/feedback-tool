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
-   When you see the login page, head over the register page, create an account and log in. After that you wil able do following thiings Add ,Comments,Like,Dislikes FeedBack.
-   `php artisan migrate` For Migration Table Into Database
-   You can utilize the database seeder by running the command `php artisan db:seed` to generate synthetic or test data for application.

## Solution ✅

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

## Markdown Format For Comment

    use     **Bold text**
    use        *italic text*
    use    ```Block Code text```

## Notification Setting

-   I have set up Mailtrap to send notifications for comments, likes, or dislikes on feedback.
-   Please ensure that your email settings are correctly configured in the `.env` file.

<!-- Link For Mailtrap -->

https://mailtrap.io/home

## Queue IN laravel

-   To ensure that comments, likes, and dislikes are queued properly and email notifications are sent,
-   Make sure to run the `php artisan queue:work` command in the background. If you don't, the queued tasks will stay in the jobs table, and no email notifications will be sent.
