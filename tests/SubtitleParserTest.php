<?php declare(strict_types=1);

namespace Iamdual\SrtParser\Tests;

use Iamdual\SrtParser\Chunks;
use Iamdual\SrtParser\Exceptions\SyntaxErrorException;
use Iamdual\SrtParser\Subtitle;
use Iamdual\SrtParser\SubtitleParser;
use PHPUnit\Framework\TestCase;

final class SubtitleParserTest extends TestCase
{
    /**
     * @covers \Iamdual\SrtParser\Chunks
     * @throws SyntaxErrorException
     */
    public function testSubtitleParser(): void
    {
        foreach (['lf', 'crlf', 'cr', 'fuzzed'] as $type) {
            $content = file_get_contents(__DIR__ . '/assets/sikidim-' . $type . '.srt');
            $chunks = new Chunks($content);
            foreach ($chunks->getChunks() as $chunk) {
                $parser = new SubtitleParser($chunk);
                $subtitle = $parser->getSubtitle();
                $this->assertInstanceOf(Subtitle::class, $subtitle);
                $this->assertIsInt($subtitle->getSequence());
                $this->assertIsInt($subtitle->getTimeBegin());
                $this->assertIsInt($subtitle->getTimeEnd());
                $this->assertGreaterThanOrEqual(1, $subtitle->getTimeBegin());
                $this->assertGreaterThanOrEqual(1, $subtitle->getTimeEnd());
                $this->assertIsString($subtitle->getContent());
            }
        }
    }
}
