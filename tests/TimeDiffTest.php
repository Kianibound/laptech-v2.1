<?php
use PHPUnit\Framework\TestCase;

class TimeDiffTest extends TestCase {
    public function testTimeDiffReturnsPositiveDifference()
    {
        $firstTime = '2024-01-01 10:00:00';
        $lastTime = '2024-01-01 10:05:00';

        $result = timeDiff($firstTime,$lastTime);

        // 5 minutes = 300 seconds
        $this->assertEquals(300, $result);
    }

    public function testTimeDiffWithSameTime()
    {
        $time = '2024-01-01 10:00:00';

        $result = timeDiff($time, $time);

        $this->assertEquals(0, $result);
    }
    public function testTimeDiffWithNegativeDifference()
    {
        $firstTime = '2024-01-01 10:05:00';
        $lastTime = '2024-01-01 10:00:00';

        $result = timeDiff($firstTime, $lastTime);

        // -5 minutes = -300 seconds
        $this->assertEquals(-300, $result);
    }

    public function testTimeDiffWithDifferentDays()
    {
        $firstTime = '2024-01-01 10:00:00';
        $lastTime = '2024-01-02 10:00:00';

        $result = timeDiff($firstTime, $lastTime);

        // 24 hours = 86400 seconds
        $this->assertEquals(86400, $result);
    }
}