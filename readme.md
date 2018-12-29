# Google Authenticator

[![Build Status](https://travis-ci.org/jocic/PHP.GoogleAuthenticator.svg?branch=master)](https://travis-ci.org/jocic/PHP.GoogleAuthenticator) [![Coverage Status](https://coveralls.io/repos/github/jocic/PHP.GoogleAuthenticator/badge.svg?branch=master)](https://coveralls.io/github/jocic/PHP.GoogleAuthenticator?branch=master) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/c7c18b4866a54e79b185978e5a180f06)](https://www.codacy.com/app/jocic/PHP.GoogleAuthenticator?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=jocic/PHP.GoogleAuthenticator&amp;utm_campaign=Badge_Grade) [![Latest Stable Version](https://poser.pugx.org/jocic/google-authenticator/v/stable)](https://packagist.org/packages/jocic/google-authenticator) [![License](https://poser.pugx.org/jocic/google-authenticator/license)](https://packagist.org/packages/jocic/google-authenticator)

Google Authenticator is a mini PHP library for implementing Multi-Factor Authentication by utilizing Google's Authenticator App. It was written to simplify the implementation process and has no other dependencies.

![Project Image](images/project-image-small.png)

Following specifications are referenced:

*   [RFC 4648](documentation/rfc4648.txt) - Base 16, Base 32 & Base 64 Data Encodings
*   [RFC 6238](documentation/rfc6238.txt) - TOTP: Time-Based One-Time Password Algorithm
*   [RFC 6287](documentation/rfc6287.txt) - OCRA: OATH Challenge-Response Algorithm
*   [ISO/IEC 18004:2015](https://www.iso.org/standard/62021.html) - QR Code Bar Code Symbology Specification

__Note:__ Composer is only used for managing testing-related libraries for development purposes, ex. PHPUnit.

[![Buy Me Coffee](images/buy-me-coffee.png)](https://www.paypal.me/DjordjeJocic)

__Project is still under development.__

## Versioning Scheme

I use a 3-digit [Semantic Versioning](https://semver.org/spec/v2.0.0.html) identifier, for example 1.0.2. These digits have the following meaning:

*   The first digit (1) specifies the MAJOR version number.
*   The second digit (0) specifies the MINOR version number.
*   The third digit (2) specifies the PATCH version number.

Complete documentation can be found by following the link above.

## Examples

Following examples should be more then enough to get you started. I tried my best to make them as simple as possible so that everyone, even junior developers, can successfully use them for implementing two-factor authentication.

### Example 1 - Generating Secret

Generating a secret is quite a straightforward process, it is done upon instantiating an object.

__Note:__ Secret is an encoded 80-bit value used for one-time password generation. It should ideally be unique for each account so you perform an appropriate check before assigning it.

```php
$secret = new Jocic\GoogleAuthenticator\Secret();

echo $secret->getValue();
```

And if you are not satisfied with the returned value, you can simply generate a new one.

```php
$newSecret = $secret->generateValue();

$secret->setValue($newSecret);
```

### Example 2 - Different Methods

Secret can be generated using two different methods:

*   __Base Method__ - Random values from the base table are picked until an 80-bit value is formed.
*   __Numerical Method__ - Random numbers, ranging from 0 to 256, are generated until an 80-bit value is formed.
*   __Binary Method__ - Random bits are chosen until an 80-bit value is formed.

The base method is used by default, so you need not specify it. However, if something is compelling you to do otherwise, Satan for example, you can use the following snippet.

```php
use Jocic\GoogleAuthenticator\Secret;

$secret = new Secret();

echo $secret->generateValue(Secret::M_BASE);

```

To generate a secret using the numerical method, use the following snippet.

```php
use Jocic\GoogleAuthenticator\Secret;

$secret = new Secret();

echo $secret->generateValue(Secret::M_NUMERICAL);
```

And finally, following snippet can be used for generating a secret using the binary method.

```php
use Jocic\GoogleAuthenticator\Secret;

$secret = new Secret();

echo $secret->generateValue(Secret::M_BINARY);
```

### Example 3 - Setting Existing Secret

Settings a pre-existing secret is extremely simple.

```php
$existingSecret = "3SJRXZHGUVHAGD7R"; // Maybe It's Fetched From The Database

$secret = new Jocic\GoogleAuthenticator\Secret();

$secret->setValue($existingSecret);
```

### Example 4 - Creating an Account

Use the following snippet when creating an account.

```php
$secret  = new Jocic\GoogleAuthenticator\Secret();
$account = new Jocic\GoogleAuthenticator\Account("Hosting ABC", "John Doe", $secret);
```

Alternatively, you can instantiate an object and set parameters later.

```php
$secret  = new Jocic\GoogleAuthenticator\Secret();
$account = new Jocic\GoogleAuthenticator\Account();

$account->setServiceName("Hosting ABC");
$account->setAccountName("john@doe.com");
$account->setAccountSecret($secret);
```

### Example 5 - Account Manager (Adding)

Account Manager class can be used for, you guessed it, managing accounts on local file system. To add an account simply use the following snippet.

```php
$accountManager = new Jocic\GoogleAuthenticator\AccountManager();

$accountManager->addAccount($account);
```

Newly added account will receive an ID used for easier referencing. Also, you should keep in mind that:

*   Account ID is only unique in relation to it's manager
*   Account can only be added to one account manager

### Example 6 - Account Manager (Removing)

...

### Example 7 - Account Manager (Finding)

...

### Example 8 - Account Manager (Saving)

...

### Example 9 - Account Manager (Loading)

...

## Installation

There's two ways you can add __Google Authenticator__ library to your project:

*   Copying files from the "source" directory to your project and requiring the "Autoload.php" script
*   Via Composer, by executing the command below

```bash
composer require jocic/google-authenticator dev-master
```

## Tests

Following unit tests are available:

*   __Essentials__ - Base 32 encoder, QR code generator, etc.
*   __Elements__ - Secret, Account, etc.
*   __Authenticator__ - Nothing right now.

You can execute them easily from the terminal like in the example below.

```bash
bash ./scripts/phpunit.sh --testsuite essentials
bash ./scripts/phpunit.sh --testsuite elements
bash ./scripts/phpunit.sh --testsuite core
```

Please don’t forget to install necessary dependencies before attempting to do the God's work above. They may be important.

```bash
bash ./scripts/composer.sh install
```

## Contribution

Please review the following documents if you are planning to contribute to the project:

*   [Contributor Covenant Code of Conduct](code_of_conduct.md)
*   [Contribution Guidelines](contributing.md)
*   [Pull Request Template](pull_request_template.md)
*   [MIT License](license.md)

## Support

Please don't hesitate to contact me if you have any questions, ideas, or concerns.

My Twitter account is: [@jocic_91](https://www.twitter.com/jocic_91)

My support E-Mail address is: [support@djordjejocic.com](mailto:support@djordjejocic.com)

## Copyright & License

Copyright (C) 2018 Đorđe Jocić

Licensed under the MIT license.
