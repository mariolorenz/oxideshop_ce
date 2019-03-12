<?php declare(strict_types=1);
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\Password\Service;

use OxidEsales\EshopCommunity\Internal\Password\Exception\PasswordPolicyException;
use OxidEsales\EshopCommunity\Internal\Password\Service\PasswordHashArgon2iService;
use OxidEsales\EshopCommunity\Tests\Integration\Internal\ContainerTrait;
use PHPUnit\Framework\TestCase;

/**
 * Class PasswordHashBcryptServiceTest
 */
class PasswordHashArgon2iServiceTest extends TestCase
{
    use ContainerTrait;

    /**
     * End-to-end test to ensure, that the password policy checking is called during password hashing
     */
    public function testPasswordHashArgon2iServiceEnforcesPasswordPolicy()
    {
        if (!defined('PASSWORD_ARGON2I')) {
            $this->markTestSkipped('The password hashing algorithm "PASSWORD_ARGON2I" is not available');
        }
        $this->expectException(PasswordPolicyException::class);

        $passwordUtf8 = 'äääääää';
        $passwordIso = mb_convert_encoding($passwordUtf8, 'ISO-8859-15');

        $passwordHashService = $this->get(PasswordHashArgon2iService::class);
        $passwordHashService->hash($passwordIso);
    }
}
