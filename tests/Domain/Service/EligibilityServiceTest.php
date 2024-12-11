<?php

namespace App\Tests\Domain\Service;

use App\Domain\Entity\Client;
use App\Domain\Service\Contract\EligibilityCheckerInterface;
use App\Domain\Service\EligibilityService;
use PHPUnit\Framework\TestCase;

class EligibilityServiceTest extends TestCase
{
    public function testIsEligibleAllCheckersPass(): void
    {
        $checker1 = $this->createMock(EligibilityCheckerInterface::class);
        $checker1->method('check')->willReturn(true);

        $checker2 = $this->createMock(EligibilityCheckerInterface::class);
        $checker2->method('check')->willReturn(true);

        $service = new EligibilityService([$checker1, $checker2]);
        $client = $this->createMock(Client::class);

        $this->assertTrue($service->isEligible($client));
    }

    public function testIsEligibleFailsIfOneCheckerFails(): void
    {
        $checker1 = $this->createMock(EligibilityCheckerInterface::class);
        $checker1->method('check')->willReturn(true);

        $checker2 = $this->createMock(EligibilityCheckerInterface::class);
        $checker2->method('check')->willReturn(false);

        $service = new EligibilityService([$checker1, $checker2]);
        $client = $this->createMock(Client::class);

        $this->assertFalse($service->isEligible($client));
    }

    public function testGetNonEligibilityReasons(): void
    {
        $checker1 = $this->createMock(EligibilityCheckerInterface::class);
        $checker1->method('check')->willReturn(true);

        $checker2 = $this->createMock(EligibilityCheckerInterface::class);
        $checker2->method('check')->willReturn(false);
        $checker2->method('getNonEligibilityExplanation')->willReturn('Low credit score');

        $service = new EligibilityService([$checker1, $checker2]);
        $client = $this->createMock(Client::class);

        $reasons = $service->getNonEligibilityReasons($client);
        $this->assertNotNull($reasons);
        $this->assertContains('Low credit score', $reasons);
    }
}
