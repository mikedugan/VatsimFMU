VatsimXMLFeeds
=========

The Vatsim Xmlfeeds package is a useful laravel package for accessing data publically presented via VATSIMs XML feeds.

Version
----

1.0

Installation
--------------

Use [Composer](http://getcomposer.org) to install the VatsimXmlfeeds and dependencies.

```sh
$ composer require vatsim/xmlfeeds 1.*
```

### Laravel
#### Set up
Using VatsimXmlfeeds in Laravel is made easy through the use of Service Providers. Add the service provider to your `app/config/app.php` file:
```php
'providers' => array(
    // ...
    'Vatsim\Xmlfeeds\XmlfeedsServiceProvider',
),
```

Followed by the alias:
```php
'aliases' => array(
    // ...
    'VatsimXmlfeeds'       => 'Vatsim\Xmlfeeds\Facades\Xmlfeeds',
),
```

#### Configuration file
You should not need to modify the default configuration file supplied by the package.


## Usage
### Getting data

This lightweight package only has one main function: getData

If you don't specify a URL to use, you will be given basic user details.
```php
VatsimXML::getData(980234)
```

Other possible data requests are as follows.

```php
VatsimXML::getData(980234, "idstatusint") // Receive basic data, but with numeric ratings rather than verbose.
VatsimXML::getData(980234, "idstatusprat") // Receive the previous rating, for ADM, SUP or INS accounts.
VatsimXML::getData(980234, "idstatusrat") // Get the number of hours controlled at each rating level.
```