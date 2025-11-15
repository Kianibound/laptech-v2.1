<?php
use PHPUnit\Framework\TestCase;

class DiffSecConvertTest extends TestCase
{
    public function testDiffSecConvertWithMinutes()
    {
        $time1 = '2024-01-01 10:00:00';
        $time2 = '2024-01-01 10:05:30';

        $result = diff_sec_convert($time1, $time2);

        // 5 minutes 30 seconds = 330 seconds
        $this->assertEquals(330, $result);
    }

    public function testDiffSecConvertWithHours()
    {
        $time1 = '2024-01-01 10:00:00';
        $time2 = '2024-01-01 13:00:00';

        $result = diff_sec_convert($time1, $time2);

        // 3 hours = 10800 seconds
        $this->assertEquals(10800, $result);
    }

    public function testDiffSecConvertWithDays()
    {
        $time1 = '2024-01-01 10:00:00';
        $time2 = '2024-01-03 10:00:00';

        $result = diff_sec_convert($time1, $time2);

        // 2 days = 172800
        $this->assertEquals(172800, $result);
    }

    public function testDiffSecConvertWithFebruaryMonth()
    {
        // Test for February month (28 days)
        $time1 = '2024-02-01 00:00:00';
        $time2 = '2024-03-01 00:00:00';

        $result = diff_sec_convert($time1, $time2);

        // February 2024 is a leap year = 29 days = 2505600 seconds
        $this->assertEquals(2505600, $result);
    }

    public function testDiffSecConvertWith30DayMonth()
    {
        // Test for April month (30 days) - this is where we'll catch the bug!
        $time1 = '2024-04-01 00:00:00';
        $time2 = '2024-05-01 00:00:00';

        $result = diff_sec_convert($time1, $time2);

        // April = 30 days = 2592000 seconds
        $this->assertEquals(2592000, $result);
    }

    public function testDiffSecConvertWith31DayMonth()
    {
        // Test for January month (31 days)
        $time1 = '2024-01-01 00:00:00';
        $time2 = '2024-02-01 00:00:00';

        $result = diff_sec_convert($time1, $time2);

        // January = 31 days = 2678400 seconds
        $this->assertEquals(2678400, $result);
    }

    public function testDiffSecConvertWithComplexInterval()
    {
        $time1 = '2024-01-15 08:30:45';
        $time2 = '2024-02-20 14:45:30';

        $result = diff_sec_convert($time1, $time2);

        // Manual calculation:
        // 16 days of January + 20 days of February = 36 days
        // + 6 hours and 14 minutes and 45 seconds
        // = 3110685 seconds
        $this->assertEquals(3132885, $result);
    }
}