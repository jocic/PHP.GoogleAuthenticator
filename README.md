# Google Authenticator

Google Authenticator is a mini PHP library for implementing Multi-Factor Authentication by utilizing Google's Authenticator App. It was written to simplify the implementation process and has no other dependencies.

Following specifications are referenced:

* [RFC 4648](documentation/rfc4648.txt) - Base 16, Base 32 & Base 64 Data Encodings
* [RFC 6238](documentation/rfc6238.txt) - TOTP: Time-Based One-Time Password Algorithm
* [RFC 6287](documentation/rfc6287.txt) - OCRA: OATH Challenge-Response Algorithm

**Note:** Composer is only used for managing testing-related libraries for development purposes, ex. PHPUnit.

[![Buy Me Coffee](images/buy-me-coffee.png)](https://www.paypal.me/DjordjeJocic)

**Project is still under development.**

## Installation

There's two ways you can add **Google Authenticator** library to your project:

* Copying the files from the "source" directory to your project and including the "Autoload.php" file
* Via Composer, by executing the command below

```bash
composer require jocic/google-authenticator
```

## Tests

Following unit tests are available:

* **Essentials** - Base 32 Encoding & Decoding

You can execute them easily from the terminal like in the example below.

```bash
bash ./tests/wrapper.sh --testsuite essentials
```

## Contribution

Please review the following documents if you are planning to contribute to the project:

* [Contributor Covenant Code of Conduct](CODE_OF_CONDUCT.md)
* [Contribution Guidelines](CONTRIBUTING.md)
* [Pull Request Template](PULL_REQUEST_TEMPLATE.md)
* [MIT License](LICENSE.md)

## Support

Please don't hessitate to contact me if you have any questions, ideas, or concerns.

My Twitter account is: [@jocic_91](https://www.twitter.com/jocic_91)

My support E-Mail address is: <support@djordjejocic.com>

## Copyright & License

Copyright (C) 2018 Đorđe Jocić

Licensed under the MIT license.
