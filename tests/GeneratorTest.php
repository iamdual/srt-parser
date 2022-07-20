<?php declare(strict_types=1);

namespace Iamdual\SrtParser\Tests;

use Iamdual\SrtParser\Generator;
use Iamdual\SrtParser\Subtitle;
use PHPUnit\Framework\TestCase;

final class GeneratorTest extends TestCase
{
    /**
     * @covers \Iamdual\SrtParser\Generator
     * @covers \Iamdual\SrtParser\Subtitle
     */
    public function testGenerator(): void
    {
        $subtitles = [];

        $subtitle = new Subtitle();
        $subtitles[] = $subtitle->setSequence(1)->setTimeBegin(1100)->setTimeEnd(2101)
            ->setContent('Rocket launch began.');

        $subtitle = new Subtitle();
        $subtitles[] = $subtitle->setSequence(2)->setTimeBegin(3900)->setTimeEnd(4781)
            ->setContent("We're on Earth and, soon coming\nout of the atmosphere.");

        $subtitle = new Subtitle();
        $subtitles[] = $subtitle->setSequence(3)->setTimeBegin(262563800)->setTimeEnd(262565001)
            ->setContent("We've now reached the Moon.");

        $subtitle = new Subtitle();
        $subtitles[] = $subtitle->setSequence(4)->setTimeBegin(12961376090)->setTimeEnd(12961378128)
            ->setContent("We've now reached the Mars.");

        $generator = new Generator($subtitles);

        $this->assertEquals(file_get_contents(__DIR__ . '/assets/space-travel.srt'), $generator->getOutput());
    }
}