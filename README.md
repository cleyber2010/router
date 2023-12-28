
###### Small and simple component to help you with the implementation of scales.

A simple router to make the developer's day-to-day life easier by applying the MVC design pattern.
The component is under development, implementing the http Post and Get verbs.

## Documentation

#### Apache

```apacheconfig
RewriteEngine On

# ROUTER URL Rewrite
RewriteCond %{SCRIPT_FILENAME} !-f
RewriteCond %{SCRIPT_FILENAME} !-d
RewriteRule ^(.*)$ index.php?route=/$1 [L,QSA]
```
##### Routes

```php
<?php

use WebRouter\Router;

$baseUrl = "https://www.localhost/plugins/router/"

$router = new Router($baseUrl);

$router->get("usuario/cadastro/{id}/{user}", "UserController:index");
$router->get("usuario/cadastro/{id}/{user}/{test}", "UserController:index");

```

###### Controller Example

```php
<?php

class UserController
{
   
    public function index(array $data)
    {
        echo "Hello Word";
        var_dump($data);
    }
    
}
```


## Contributing

Please see [CONTRIBUTING](https://github.com/cleyber2010/router/blob/master/CONTRIBUTING.md) for details.

## Support

###### Security: If you discover any security related issues, please email cleyber.fernandes@gmail.com instead of using the issue tracker.

Thank you

## Credits

- [Cleyber F. Matos](https://github.com/cleyber2010) (Developer)
- [All Contributors](https://github.com/cleyber2010/router/contributors)

## License

The MIT License (MIT). Please see [License File](https://github.com/cleyber2010/router/blob/master/LICENSE) for more
information.