Laravel Validation was created by, and is maintained by **[Ano Van](https://github.com/anovanmaximuz)**, and is a package designed to support validation request on Laravel.

* It's included on **[Laravel Lumen](https://lumen.laravel.com)**, the most popular free, open-source PHP framework in the world.

## Installation & Usage

> **Requires [PHP 7.3+](https://php.net/releases/)**

Require Laravel Validation using [Composer](https://getcomposer.org):

```bash
composer require anovanmaximuz/laravel-validation
```


As an example, here is how to require Laravel Validation on Laravel 8.x:

```bash
$paramsChecks = $class->request($request, [
                'partnerServiceId' => 'required|max:9|string',
                'customerNo'=>'required|string|max:20',
                'virtualAccountNo'=>'required|string|max:28',
                'trxDateInit'=>'required|date|max:25',
                'channelCode'=>'required|int|max:4',
                'inquiryRequestId'=>'required|string|max:128'
            ],'parameter', true);
```

## Support Validations
* Request parameter validation POST, GET
* Header validation
