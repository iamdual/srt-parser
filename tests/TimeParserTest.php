<?php declare(strict_types=1);

namespace Iamdual\SrtParser\Tests;

use Iamdual\SrtParser\Exceptions\SyntaxErrorException;
use Iamdual\SrtParser\TimeParser;
use PHPUnit\Framework\TestCase;

final class TimeParserTest extends TestCase
{
    /**
     * @covers \Iamdual\SrtParser\TimeParser
     * @throws SyntaxErrorException
     */
    public function testTimeParser1(): void
    {
        $timeParser = new TimeParser('00:02:14,648 --> 00:02:15,980');
        $time = $timeParser->getTime();
        $this->assertEquals(134648, $time->getBegin());
        $this->assertEquals(135980, $time->getEnd());
    }

    /**
     * @covers \Iamdual\SrtParser\TimeParser
     * @throws SyntaxErrorException
     */
    public function testTimeParser2(): void
    {
        $timeParser = new TimeParser('2400:00:00,000 --> 2400:00:00,100');
        $time = $timeParser->getTime();
        $this->assertEquals(8640000000, $time->getBegin());
        $this->assertEquals(8640000100, $time->getEnd());
    }
}
