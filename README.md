![alt text](https://repository-images.githubusercontent.com/264064758/3083f000-9629-11ea-880f-c2d6542e4b6a?raw=true)

# Symlink Helper


This package allows you to easily and quickly generate symlinks 
of any given files and or directories.

* Ensure you have and are running PHP 7 and above

* Fully Objected Oriented
* Chained methods
* Interactive API


## Getting Started

### 1. Install

Run the following command:

```bash
composer require simtabi/symlink
```

### 2. Use case scenarios.

If you want to use within a class/project, install
 the project via composer and user as follows:


```php
use Simtabi\Symlink; 

$symlinkInit = new Symlink();
$obj = $symlinkInit->setBatchJobs([
        [
            'destination' => 'path_to_destination/folder_name_1',
            'source'      => 'path_to_create_file/folder_name',
        ],
        [
           'destination' => 'path_to_destination/folder_name_1',
           'source'      => 'path_to_create_file/folder_name',
        ]
    ])
    ->generate();
```
#### 1. Create multiple symlinks at ago.
In this use-case, you have to provide an `array` list of the path to the file/link to be 
created a symlink for and the destination path and file `alias` name. To achieve
this, use the following method.
```php
 ->setBatchJobs([
// sources here
   'destination' => 'path_to_destination/folder_name_1',
   'source'      => 'path_to_create_file/folder_name',
]);
```
#### 2. Create a single symlink at ago.
In this use-case, you have to provide an `array` list of the path to the file/link to be 
created a symlink for and the destination path and file `alias` name. To achieve
this, use the following method.
```php
 ->setSource( 'source')->setDestination('destination');
```
#### 3. Using it.

If you want to use within a file and you don't need composer setup, I have 
initialized a composer autoload for you and all you have to do is 
require/include the composer autoload file within the location where
you want to use it. In this case we assume:  `include_once 'vendor/autoload.php';`
See included `test.php` file for more examples.


```php
include_once 'symlink/src/Symlink.php';
use Simtabi\Symlink;

$symlinkInit = new Symlink();
$symlinkInit
       ->setSource( 'source')
       ->setDestination('destination')
      ->generate();
```

### 3. API Methods

These are the available methods.

#### Setters

```php
->setSource($source) // define source path
->setDestination($destination) // define destination path
->setGenerated(string $generated, $key) // capture and store all registered links
->setMessages(string $messages, $key) // capture and store all error messages
->setBatchJobs(array $batchJobs) // define multiple symlinks to be created
```

#### Getters

```php
->getSource() // get source path
->getDestination() // get destination path
->getGenerated() // get all stored registered links
->getMessages() // get all stored error messages
->getBatchJobs() // get all symlinks to be created
```

#### Generate
When the `$echo` is set to `TRUE`, it will output the error messages to the screen.
```php
->generate($echo = true) // generate method. 
```

## Changelog

Please see [Releases](../../releases) for more information what has changed recently.

## Contributing

Pull requests are more than welcome. You must follow the PSR coding standards.

## Security

If you discover any security related issues, please email security@simtabi.com instead of using the issue tracker.

## Credits

- [Imani Manyara](https://github.com/imanimanyara)
- [Easter Manyara](https://simtabi.com/)
- [All Contributors](../../contributors)

## Copyright
© 2020 Simtabi, LLC

### License

The MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.

