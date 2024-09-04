<p align="center">
    <img src="https://github.com/debugmate/php/blob/develop/debugmate-logo.png?raw=true" alt="Debugmate" title="Debugmate" width="300"/>
</p>

<p align="center" style="margin-top: 6px; margin-bottom: 10px;">
    <a href="https://devsquad.com">
        <img src="https://github.com/debugmate/php/blob/develop/devsquad-logo.png?raw=true" alt="DevSquad" title="DevSquad" width="150"/>
    </a>
</p>

Debugmate is a beautiful error tracking package that will help your software team to track and fix errors.

## Composer Installation

This package is compatible with **PHP 7.3 or greater**.

#### Add these lines to the _composer.json_ file in your project root:

```json
"repositories": [
   {
      "type": "composer",
      "url": "https://devsquad.repo.repman.io"
   }
]
```

#### Create the _auth.json_ file with this content in your project root:

```json
{
    "http-basic": {
        "devsquad.repo.repman.io": {
            "username": "1fc2d46ccf0406664c6427da36c26c3bebadd220b86ff7aed078def2ca03ebd6",
            "password": "1fc2d46ccf0406664c6427da36c26c3bebadd220b86ff7aed078def2ca03ebd6"
        }
    }
}
```

#### Now you can install the package:

```bash
composer require debugmate/php
```

## Configuration
So that the debugmate can send the errors to the application you need to define this environment configuration in your .env file

```env
DEBUGMATE_DOMAIN=http://fake-debugmate.app/
DEBUGMATE_TOKEN=project-token
```

## Testing

You're able to send a fake error to the Debugmate as a test by running this command:

```php
./vendor/bin/debugmate test
```

## Set logged user

Using the function below when reporting an error, the debugmate will send the data of the logged in user according to what was returned by Closure.

```php
\Debugmate\Debugmate::setUser(function() {
    return ['name'=>'name', 'email'=>'user@email.com'...];
});
```

## Reporting Unhandled Exceptions

To ensure all unhandled errors and exceptions are automatically reported to Debugmate, register our exception handler with the following code:

```php
\Debugmate\Exceptions\Handler::register()
```