<?php

declare(strict_types=1);

namespace AndKom\Ethereum\Address\Tests;

use AndKom\Ethereum\Address\Address;
use PHPUnit\Framework\TestCase;

/**
 * Class AddressTest
 * @package AndKom\Ethereum\Address\Tests
 */
class AddressTest extends TestCase
{
    const PUBKEY = '79be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f81798483ada7726a3c4655da4fbfc0e1108a8fd17b448a68554199c47d08ffb10d4b8';
    const PUBKEY_SEC = '0479be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f81798483ada7726a3c4655da4fbfc0e1108a8fd17b448a68554199c47d08ffb10d4b8';

    /**
     * @throws \Exception
     */
    public function testEncode()
    {
        $this->assertEquals('0x7E5F4552091A69125d5DfCb7b8C2659029395Bdf', Address::encode(static::PUBKEY));
    }

    /**
     * @throws \Exception
     */
    public function testEncodeSec()
    {
        $this->assertEquals('0x7E5F4552091A69125d5DfCb7b8C2659029395Bdf', Address::encode(static::PUBKEY_SEC));
    }

    /**
     * @throws \Exception
     */
    public function testEncodeRaw()
    {
        $this->assertEquals('0x7E5F4552091A69125d5DfCb7b8C2659029395Bdf', Address::encode(hex2bin(static::PUBKEY)));
    }

    /**
     * @throws \Exception
     */
    public function testEncodeNoChecksum()
    {
        $this->assertEquals('0x7e5f4552091a69125d5dfcb7b8c2659029395bdf', Address::encode(static::PUBKEY, false));
    }

    /**
     * @throws \Exception
     */
    public function testInvalidPublicKeyLength()
    {
        $this->expectExceptionMessage('Invalid public key.');
        Address::encode('');
    }

    /**
     * @throws \Exception
     */
    public function testInvalidPublicKey()
    {
        $this->expectExceptionMessage('Invalid public key.');
        Address::encode('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
    }

    /**
     * @throws \Exception
     */
    public function testInvalidPublicKeyPrefix()
    {
        $this->expectExceptionMessage('Invalid public key.');
        Address::encode('03aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaabbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb');
    }

    /**
     * @throws \Exception
     */
    public function testIsValid()
    {
        $this->assertTrue(Address::isValid('0x7E5F4552091A69125d5DfCb7b8C2659029395Bdf'));
        $this->assertTrue(Address::isValid('0x7e5f4552091a69125d5dfcb7b8c2659029395bdf'));
        $this->assertFalse(Address::isValid(''));
        $this->assertFalse(Address::isValid('7E5F4552091A69125d5DfCb7b8C2659029395Bdf'));
        $this->assertFalse(Address::isValid('0xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'));
        $this->assertFalse(Address::isValid('0x8E5F4552091A69125d5DfCb7b8C2659029395Bdf'));
    }

    /**
     * @throws \Exception
     */
    public function testToChecksumAddress()
    {
        $this->assertEquals('0x7E5F4552091A69125d5DfCb7b8C2659029395Bdf', Address::toChecksumAddress('0x7e5f4552091a69125d5dfcb7b8c2659029395bdf'));
        $this->assertEquals('0x7E5F4552091A69125d5DfCb7b8C2659029395Bdf', Address::toChecksumAddress('0x7E5F4552091A69125d5DfCb7b8C2659029395Bdf'));
    }
}