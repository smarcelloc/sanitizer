# Sanitizer

Data sanitizer and form request input sanitization for Laravel and Normal PHP.

## Filtering and Sanitizing

Sanitizing user input is a critical part of software development. Trusting or neglecting to sanitize user input could lead to unauthorized access to the content of your application, mainly user data, or even the server your application is hosted on.

![Image about sanitizing](https://d33wubrfki0l68.cloudfront.net/d1decd46dff0fa95788f5647a0c6edef23103e0f/fff15/assets/images/content/filter-sql.png)

[Full image on XKCD](https://xkcd.com/327/)

## Introduction

Sanitizer provides an easy way to format user input, both through the provided filters or through custom ones that can easily be added to the sanitizer library.

**Although not limited to Laravel and can be used in NORMAL PHP.**

## Install

### Install in PHP Normal

To install, just run:

```shell
composer require smarcelloc/sanitizer
```

### Install in Laravel

To install, just run:

```shell
composer require smarcelloc/sanitizer
```

And you're done! If you're using Laravel, in order to be able to access some extra functionality you must register both the Service provider in the providers array in `config/app.php`, as well as the Sanitizer Facade:

```php
'providers' => [
    ...
    Sanitizer\Laravel\SanitizerServiceProvider::class,
];

'aliases' => [
    ...
    'Sanitizer' => Sanitizer\Laravel\Facade::class,
];
```

## Use Example

Given a data array with the following format:

```php
$data = [
    'first_name' => 'john',
    'last_name' => '<strong>DOE</strong>',
    'email' => '  JOHn@DoE.com',
    'birthdate' => '06/25/1980',
    'jsonVar' => '{"name":"value"}',
    'description' => '<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>',
    'phone' => '+08(096)90-123-45q',
    'country' => 'GB',
    'postcode' => 'ab12 3de',
];

use Sanitizer\Sanitizer;

$filters = [
    'first_name' => 'title',
    'last_name' => 'trim|strip_tags|title',
    'email' => 'trim|lower',
    'birthdate' => 'fdate:m/d/Y, Y-m-d',
    'jsonVar' => 'cast:array',
    'description' => 'strip_tags',
    'phone' => 'digit',
    'country' => 'trim',
    'postcode' => 'upper|if:country,GB',
];

$sanitizer  = new Sanitizer($data, $filters);
var_dump($sanitizer->sanitize());
```

Which will yield:

```php
[
    'first_name' => 'John',
    'last_name' => 'Doe',
    'email' => 'john@doe.com',
    'birthdate' => '1980-06-25',
    'jsonVar' => '["name" => "value"]',
    'description' => 'Test paragraph. Other text',
    'phone' => '080969012345',
    'country' => 'GB',
    'postcode' => 'AB12 3DE',
];
```

It's usage is very similar to Laravel's Validator module, for those who are already familiar with it, although Laravel is not required to use this library.

Filters are applied in the same order they're defined in the $filters array. For each attribute, filters are separered by | and options are specified by suffixing a comma separated list of arguments (see fdate).

## Available filters

The following filters are available out of the box:

| Name | Description |
---- | ----
**trim** | Trims a string
**escape** | Escapes HTML and special chars using `htmlspecialchars`
**lower** | Converts the given string to all lowercase
**upper** | Converts the given string to all uppercase
**title** | Title a string
**cast** | Casts a variable into the given type. Options are: `integer`, `double`, `string`, `boolean`, `array`, `object` and `collection`.
**fdate** | Always takes two arguments, the date's given format and the target format, following DateTime notation.
**strip_tags** | Strip HTML and PHP tags using php's strip_tags
**digit** | Get only digit characters from the string
**if** | Applies filters if an attribute exactly matches value

## Adding custom filters

You can add your own filters by passing a custom filter array to the Sanitize constructor as the third parameter. For each filter name, either a closure or a full classpath to a Class extends the Sanitizer\Filter interface must be provided. Closures must always accept two parameters: $value and an $options array:

### Extends Class Filter

```php
class RemoveStringsFilter extends Sanitizer\Filter
{
    /**
     * Choose allows types variables to apply filter.
     *
     * @var array - Example: ['string', 'integer', 'boolean', 'double', 'array']
     */
    protected $allowType = ['string'];

    public function apply(string $value, array $options = [])
    {
        return str_replace($options, '', $value);
    }
}
```

```php
$customFilters = [
    'remove_strings' => RemoveStringsFilter::class,
];

$filters = [
    'text' => 'remove_strings:Curse,Words,Galore',
];

$sanitize = new Sanitize($data, $filters, $customFilters);
```

### Closure

```php
 $customFilters = [
    'hash' =>   function($value, $options = []) {
                    return sha1($value);
                },
];

$filters = [
    'secret' => 'hash',
];

$sanitize = new Sanitize($data, $filters, $customFilters);
```

## Laravel goodies

If you are using Laravel, you can use the Sanitizer through the Facade:

```php
$newData = \Sanitizer::make($data, $filters)->sanitize();
```

You can also easily extend the Sanitizer library by adding your own custom filters, just like you would the Validator library in Laravel, by calling extend from a ServiceProvider like so:

```php
\Sanitizer::extend($filterName, $closureOrClassPath);
```

You may also Sanitize input in your own FormRequests by using the SanitizesInput trait, and adding a _filters_ method that returns the filters that you want applied to the input.

```php
namespace App\Http\Requests;

use App\Http\Requests\Request;
use Sanitizer\Laravel\SanitizesInput;

class SanitizedRequest extends Request
{
    use SanitizesInput;

    public function filters()
    {
        return [
            'name'  => 'trim|title',
            'email' => 'trim',
            'text'  => 'remove_strings:Curse,Words,Galore',
        ];
    }

    public function customFilters()
    {
        return [
            'remove_strings' => RemoveStringsFilter::class,
        ];
    }
}
```

To generate a Sanitized Request just execute the included Artisan command:

```shell
php artisan sanitizer:request NameSanitizedRequest
```

The only difference with a Laravel FormRequest is that now you'll have an extra 'fields' method in which to enter the input filters you wish to apply, and that input will be sanitized before being validated.

### License

Sanitizer is licensed under The [MIT License](https://github.com/smarcelloc/sanitizer/blob/master/LICENSE).
