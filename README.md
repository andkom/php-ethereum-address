## PHP Ethereum Address

A simple Ethereum address encoder/validator written in PHP.

### Installation

```bash
composer require andkom/ethereum-address
```

### Usage

Encode public key into address:

```php
$address = Address:encode($pubKey);
```

Validate address:

```php
$isValid = Address::isValid($address);
```

Convert address into case-sensitive checksum address:

```php
$checksumAddress = Address::toChecksumAddress($address);
```