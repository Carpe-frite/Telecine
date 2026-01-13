<?php

use App\Entity\User;
use App\Entity\Event;
use App\Service\EventUserChecker;
use PHPUnit\Framework\TestCase;

final class EventUserCheckerTest extends TestCase
{
    public function testEventUserCheckerWithRegularUserCreatorAndEvent(): void {
        $checker = new EventUserChecker();

        $mockUser = $this->createMock(User::class);
        $mockEvent = $this->createMock(Event::class);

        $mockEvent->method('getUser')->willReturn($mockUser);

        $checking = $checker->checkIfEventCreatedByUser($mockUser, $mockEvent);

        $this->assertSame(true, $checking);
    }

    public function testEventUserCheckerWithAdminUserAndEvent(): void {
        $checker = new EventUserChecker();

        $mockUser = $this->createMock(User::class);
        $mockEvent = $this->createMock(Event::class);

        $mockUser->method('getRoles')->willReturn(['ROLE_ADMIN']);

        $checking = $checker->checkIfEventCreatedByUser($mockUser, $mockEvent);

        $this->assertSame(true, $checking);
    }

    public function testEventUserCheckerWithRegularNotCreatorUserAndEvent(): void {
        $checker = new EventUserChecker();

        $mockUser = $this->createMock(User::class);
        $mockEvent = $this->createMock(Event::class);

        $mockUser->method('getRoles')->willReturn(['ROLE_USER']);

        $checking = $checker->checkIfEventCreatedByUser($mockUser, $mockEvent);

        $this->assertSame(false, $checking);
    }
}