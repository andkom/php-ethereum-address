<?php

declare(strict_types=1);

namespace AndKom\Ethereum\Address;

use kornrunner\Keccak;

/**
 * Class Address
 * @package AndKom\Ethereum\Address
 */
class Address
{
    /**
     * @param string $address
     * @return string
     * @throws \Exception
     */
    protected static function checksumEncode(string $address): string
    {
        $checksum = Keccak::hash($address, 256);

        for ($i = 0; $i < strlen($address); $i++) {
            if (intval($checksum[$i], 16) >= 8) {
                $address[$i] = strtoupper($address[$i]);
            }
        }

        return $address;
    }

    /**
     * @param string $pubKey
     * @param bool $checksum
     * @return string
     * @throws \Exception
     */
    public static function encode(string $pubKey, bool $checksum = true): string
    {
        if (ctype_xdigit($pubKey)) {
            $pubKey = hex2bin($pubKey);
        }

        $length = strlen($pubKey);

        if ($length == 65 && $pubKey[0] == "\x04") {
            $pubKey = substr($pubKey, 1);
        } elseif ($length != 64) {
            throw new Exception('Invalid public key.');
        }

        $hash = Keccak::hash($pubKey, 256);
        $address = substr($hash, -40);

        if ($checksum) {
            $address = static::checksumEncode($address);
        }

        return '0x' . $address;
    }

    /**
     * @param string $address
     * @return bool
     * @throws \Exception
     */
    public static function isValid(string $address): bool
    {
        if (strlen($address) != 42 || strpos($address, '0x') !== 0) {
            return false;
        }

        $address = substr($address, 2);

        if (!ctype_xdigit($address)) {
            return false;
        }

        $lower = strtolower($address);

        if ($lower == $address) {
            return true;
        }

        return $address == static::checksumEncode($lower);
    }

    /**
     * @param string $address
     * @return string
     * @throws \Exception
     */
    public static function toChecksumAddress(string $address): string
    {
        if (!static::isValid($address)) {
            throw new Exception('Invalid address.');
        }

        $address = strtolower(substr($address, 2));

        return '0x' . static::checksumEncode($address);
    }
}