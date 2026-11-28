# Google Authenticator

[![Coverage Status](https://coveralls.io/repos/github/jocic/PHP.GoogleAuthenticator/badge.svg?branch=master)](https://coveralls.io/github/jocic/PHP.GoogleAuthenticator?branch=master)
[![Latest Stable Version](https://poser.pugx.org/jocic/google-authenticator/v/stable)](https://packagist.org/packages/jocic/google-authenticator)
[![License](https://poser.pugx.org/jocic/google-authenticator/license)](https://packagist.org/packages/jocic/google-authenticator)

Google Authenticator is a mini PHP library for implementing Multi-Factor Authentication.

![Project Image](images/project-image-small.png)

Following specifications were referenced:

*   [RFC 4226](other/specifications/rfc4226.txt) - HMAC-Based One-Time Password Algorithm
*   [RFC 6238](other/specifications/rfc6238.txt) - TOTP: Time-Based One-Time Password Algorithm
*   [RFC 6287](other/specifications/rfc6287.txt) - OCRA: OATH Challenge-Response Algorithm

## Versioning Scheme

I use a 3-digit [Semantic Versioning](https://semver.org/spec/v2.0.0.html) identifier, for example 1.0.2. These digits have the following meaning:

*   The first digit (1) specifies the MAJOR version number.
*   The second digit (0) specifies the MINOR version number.
*   The third digit (2) specifies the PATCH version number.

Complete documentation can be found by following the link above.

## Examples

Following examples should be more then enough to get you started.

1.  [Installation](https://github.com/jocic/PHP.GoogleAuthenticator/wiki/Installation)
1.  [Creating a Secret](https://github.com/jocic/PHP.GoogleAuthenticator/wiki/Creating-a-Secret)
2.  [Creating an Account](https://github.com/jocic/PHP.GoogleAuthenticator/wiki/Creating-an-Account)
3.  [QR Codes](https://github.com/jocic/PHP.GoogleAuthenticator/wiki/QR-Codes)
4.  [Code Validation](https://github.com/jocic/PHP.GoogleAuthenticator/wiki/Code-Validation)
5.  [Tests](https://github.com/jocic/PHP.GoogleAuthenticator/wiki/Tests)

Additional examples can be found on the official project's [wiki](https://github.com/jocic/PHP.GoogleAuthenticator/wiki).

## Requirements

You need to have PHP >=8.5 available on your system to use **Google Authenticator** in your application.

Additionally, you should have the following PHP extensions installed as well:
*   [Multibyte String](https://secure.php.net/manual/en/book.mbstring.php)
*   [DOM](https://secure.php.net/manual/en/dom.setup.php)

```bash
apt-get install php-mbstring php-xml php-gd -y
```

## Installation

There's two ways you can add **Google Authenticator** library to your project:

*   Copying files from the `source` directory to your project and requiring the `Autoload.php` script (this includes doing the same for project's dependencies ex. Encoders)
*   Via Composer, by executing the command below

```bash
composer require jocic/google-authenticator 1.1.0
```

## Tests

Following unit tests are available:

*   Essentials
*   Library
*   Encoders

Reference the examples below if you ever need to run them.

### Installing Dependencies

```bash
bash ./scripts/composer.sh install
```

### Running Unit Tests

```bash
bash ./scripts/phpunit.sh --testsuite essentials
bash ./scripts/phpunit.sh --testsuite library
bash ./scripts/phpunit.sh --testsuite encoders
```

## Copyright & License

Copyright (C) 2026 Đorđe Jocić

Licensed under the MIT license.
