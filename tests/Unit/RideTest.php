<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class RideTest extends TestCase
{
    /**
     * Test if a Ride can be created
     */
    public function test_create_ride(): void
    {
        $ride = new Ride([
            'pickup' => 'Test Pickup',
            'dropoff' => 'Test Dropoff',
            'date' => now()->toDateString(),
            'distance' => 10,
            'cost' => 100,
        ]);

        $this->assertEquals('Test Pickup', $ride->pickup);
        $this->assertEquals('Test Dropoff', $ride->dropoff);
        $this->assertEquals(now()->toDateString(), $ride->date);
        $this->assertEquals(10, $ride->distance);
        $this->assertEquals(100, $ride->cost);
    }
}
