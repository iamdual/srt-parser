<?php declare(strict_types=1);

namespace Iamdual\SrtParser\Tests;

use Iamdual\SrtParser\Chunks;
use Iamdual\SrtParser\Exceptions\SyntaxErrorException;
use Iamdual\SrtParser\SubtitleParser;
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
        $timeParser = new TimeParser('00:00:00,000 --> 00:00:01,002');
        $time = $timeParser->getTime();
        $this->assertEquals(0, $time->getBegin());
        $this->assertEquals(1002, $time->getEnd());
    }

    /**
     * @covers \Iamdual\SrtParser\TimeParser
     * @throws SyntaxErrorException
     */
    public function testTimeParser2(): void
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
    public function testTimeParser3(): void
    {
        $timeParser = new TimeParser('2400:00:00,000 --> 2400:00:00,100');
        $time = $timeParser->getTime();
        $this->assertEquals(8640000000, $time->getBegin());
        $this->assertEquals(8640000100, $time->getEnd());
    }

    /**
     * @covers \Iamdual\SrtParser\TimeParser
     * @throws SyntaxErrorException
     */
    public function testTimeParserInvalid(): void
    {
        $this->expectException(SyntaxErrorException::class);
        $timeParser = new TimeParser('00:02:14,648 => 00:02:15,980');
        $timeParser->getTime();
    }

    /**
     * @covers \Iamdual\SrtParser\TimeParser
     */
    public function testToMilliseconds(): void
    {
        $this->assertEquals(1, TimeParser::toMilliseconds(0, 0, 0, 1));
        $this->assertEquals(1000, TimeParser::toMilliseconds(0, 0, 1, 0));
        $this->assertEquals(2999, TimeParser::toMilliseconds(0, 0, 2, 999));
        $this->assertEquals(59000, TimeParser::toMilliseconds(0, 0, 59, 0));
        $this->assertEquals(60000, TimeParser::toMilliseconds(0, 1, 0, 0));
        $this->assertEquals(61000, TimeParser::toMilliseconds(0, 1, 1, 0));
        $this->assertEquals(3600000, TimeParser::toMilliseconds(1, 0, 0, 0));
        $this->assertEquals(134648, TimeParser::toMilliseconds(0, 2, 14, 648));
        $this->assertEquals(8640000000, TimeParser::toMilliseconds(2400, 0, 0, 0));
    }

    /**
     * @covers \Iamdual\SrtParser\TimeParser
     */
    public function testToSrtFormat(): void
    {
        $this->assertEquals('00:00:00,001', TimeParser::toSrtFormat(1));
        $this->assertEquals('00:00:01,000', TimeParser::toSrtFormat(1000));
        $this->assertEquals('00:00:02,999', TimeParser::toSrtFormat(2999));
        $this->assertEquals('00:00:59,000', TimeParser::toSrtFormat(59000));
        $this->assertEquals('00:01:00,000', TimeParser::toSrtFormat(60000));
        $this->assertEquals('00:01:01,000', TimeParser::toSrtFormat(61000));
        $this->assertEquals('01:00:00,000', TimeParser::toSrtFormat(3600000));
        $this->assertEquals('00:02:14,648', TimeParser::toSrtFormat(134648));
        $this->assertEquals('2400:00:00,000', TimeParser::toSrtFormat(8640000000));
    }

    /**
     * @covers \Iamdual\SrtParser\TimeParser
     * @covers \Iamdual\SrtParser\Chunks
     * @covers \Iamdual\SrtParser\SubtitleParser
     */
    public function testTheTimeByAFile(): void
    {
        $content = file_get_contents(__DIR__ . '/assets/space-travel.srt');
        $chunks = new Chunks($content);
        foreach ($chunks->getChunks() as $chunk) {
            $parser = new SubtitleParser($chunk);
            $subtitle = $parser->getSubtitle();

            switch ($subtitle->getSequence()) {
                case 1:
                    $beginTime = ['00', '00', '01', '100'];
                    $endTime = ['00', '00', '02', '101'];
                    break;
                case 2:
                    $beginTime = ['00', '00', '03', '900'];
                    $endTime = ['00', '00', '04', '781'];
                    break;
                case 3:
                    $beginTime = ['72', '56', '03', '800'];
                    $endTime = ['72', '56', '05', '001'];
                    break;
                case 4:
                    $beginTime = ['3600', '22', '56', '090'];
                    $endTime = ['3600', '22', '58', '128'];
            }

            $this->assertEquals($subtitle->getTimeBegin(),
                TimeParser::toMilliseconds((int)$beginTime[0], (int)$beginTime[1], (int)$beginTime[2], (int)$beginTime[3]));
            $this->assertEquals($subtitle->getTimeEnd(),
                TimeParser::toMilliseconds((int)$endTime[0], (int)$endTime[1], (int)$endTime[2], (int)$endTime[3]));

            $this->assertEquals(sprintf('%s:%s:%s,%s', $beginTime[0], $beginTime[1], $beginTime[2], $beginTime[3])
                , TimeParser::toSrtFormat($subtitle->getTimeBegin()));
            $this->assertEquals(sprintf('%s:%s:%s,%s', $endTime[0], $endTime[1], $endTime[2], $endTime[3])
                , TimeParser::toSrtFormat($subtitle->getTimeEnd()));
        }
    }
}