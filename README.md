## Laravel Office365

A Office365 package for Laravel 5.2 or higher
 
##Installation

````
composer require moathdev/office365-laravel
````
After install this package you have to set the service provider on your config/app.php file

````
Moathdev\Office365\ServiceProvider::class,
````

To use the facade add this to the facades in app/config/app.php
````
'Office365' => Moathdev\Office365\Facade\Office365::class,
````
Then you just need to publish files ! Copy and paste it

````
php artisan vendor:publish --provider="Moathdev\Office365\ServiceProvider"
````


Get your app id and secret from [Application Registration Portal](https://apps.dev.microsoft.com) then put it in **Environment** file

````
OFFICE365_APP_ID=

OFFICE365_SECRET_APP_KEY=

OFFICE365_REDIRECT_URI=http://localhost:8000/redirect

OFFICE365_SCOPES='openid profile offline_access User.Read Mail.Read'

````
##Example Usage
````
<?php

namespace App\Http\Controllers;

use Moathdev\Office365\Facade\Office365;

class AuthController extends Controller
{
    public function signin()
    {
        $link = Office365::login();

        return redirect($link);
    }

    public function redirect()
    {
        if (!request()->has('code')) {
            abort(500);
        }

        $code = Office365::getAccessToken(request()->get('code'));

        $user = Office365::getUserInfo($code['token']);

        $messages = Office365::getEmails($code['token']);

        dd($user, $messages);
    }
}
 ````
Methods supported by this package and their parameters can be found in the [API Reference](https://docs.microsoft.com/en-us/outlook/rest/php-tutorial) 
##Issues

````

If you have any questions or issues, please open an Issue .