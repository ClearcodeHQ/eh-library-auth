## Features
- register user
- authenticate JWT
- generate JWT
- get user


see [LibraryAuth](https://github.com/ClearcodeHQ/eh-library-auth/blob/master/src/LibraryAuth.php) class

## Usage

use Application class that implements LibraryAuth features

```php

use Clearcode\EHLibraryAuth\Application;

$app = new Application();


$app->registerUser('johndoe@example.com', ['reader']);

$token = $app->generateToken('johndoe@example.com');

$app->authenticate($token);

$user = $app->getUser('johndoe@example.com');


```