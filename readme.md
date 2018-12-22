# Google Authenticator

Google Authenticator is a mini PHP library for implementing Multi-Factor Authentication by utilizing Google's Authenticator App. It was written to simplify the implementation process and has no other dependencies.

Following specifications are referenced:

* [RFC 4648](documentation/rfc4648.txt) - Base 16, Base 32 & Base 64 Data Encodings
* [RFC 6238](documentation/rfc6238.txt) - TOTP: Time-Based One-Time Password Algorithm
* [RFC 6287](documentation/rfc6287.txt) - OCRA: OATH Challenge-Response Algorithm

**Note:** Composer is only used for managing testing-related libraries for development purposes, ex. PHPUnit.

[![Buy Me Coffee](images/buy-me-coffee.png)](https://www.paypal.me/DjordjeJocic)

**Project is still under development.**

## Example 1 - Generating Secret

Generating a unique secret is quite a straightforward process, it is done upon instantiating an object.

```php
$secret = new Security\Mfa\GoogleAuthenticator\Elements\Secret();

echo $secret->getValue();
```

And if you are not satisfied with the returned value, you can simply generate a new one.

```php
$newSecret = $secret->generateValue();

$secret->setValue($newSecret);
```

You can skip the second step from the example above by changing the optional parameter value. Doing that will set newly generated secret automatically.

```php
echo $secret->generateValue(true);
```

## Example 2 - Setting Existing Secret

Settings a pre-existing secret is extremely simple.

```php
$existingSecret = "3SJRXZHGUVHAGD7R"; // Maybe It's Fetched From The Database

$secret = new Security\Mfa\GoogleAuthenticator\Elements\Secret();

$secret->setValue($existingSecret);
```

## Installation

There's two ways you can add **Google Authenticator** library to your project:

* Copying files from the "source" directory to your project and requiring the "Autoload.php" script
* Via Composer, by executing the command below

```bash
composer require jocic/google-authenticator
```

## Tests

Following unit tests are available:

* **Essentials** - Base 32 encoder, QR code generator, etc.
* **Elements** - Secret, etc.

You can execute them easily from the terminal like in the example below.

```bash
bash ./tests/wrapper.sh --testsuite essentials
bash ./tests/wrapper.sh --testsuite elements
```

## Contribution

Please review the following documents if you are planning to contribute to the project:

* [Contributor Covenant Code of Conduct](code_of_conduct.md)
* [Contribution Guidelines](contributing.md)
* [Pull Request Template](pull_request_template.md)
* [MIT License](license.md)

## Support

Please don't hessitate to contact me if you have any questions, ideas, or concerns.

My Twitter account is: [@jocic_91](https://www.twitter.com/jocic_91)

My support E-Mail address is: <support@djordjejocic.com>

## Copyright & License

Copyright (C) 2018 Đorđe Jocić

Licensed under the MIT license.
