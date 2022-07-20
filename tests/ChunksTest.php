<?php declare(strict_types=1);

namespace Iamdual\SrtParser\Tests;

use Iamdual\SrtParser\Chunks;
use PHPUnit\Framework\TestCase;

final class ChunksTest extends TestCase
{
    /**
     * @covers \Iamdual\SrtParser\Chunks
     */
    public function testChunks(): void
    {
        foreach (['lf', 'crlf', 'cr', 'fuzzed'] as $type) {
            $content = file_get_contents(__DIR__ . '/assets/simarik-' . $type . '.srt');
            $chunks = new Chunks($content);
            $chunks_array = $chunks->getChunks();
            $this->assertCount(6, $chunks_array, "chunks_array count invalid on '$type'");
            $this->assertTrue(strlen($chunks_array[0]) == 44, "1st chunk length invalid on '$type'");
            $this->assertTrue(strlen($chunks_array[1]) == 80, "2rd chunk length invalid on '$type'");
            $this->assertTrue(strlen($chunks_array[2]) == 95, "3rd chunk length invalid on '$type'");
            $this->assertTrue(strlen($chunks_array[3]) == 76, "4th chunk length invalid on '$type'");
            $this->assertTrue(strlen($chunks_array[4]) == 55, "5th chunk length invalid on '$type'");
            $this->assertTrue(strlen($chunks_array[5]) == 70, "6th chunk length invalid on '$type'");
        }
    }

    /**
     * @covers \Iamdual\SrtParser\Chunks
     */
    public function testChunks2(): void
    {
        $content = file_get_contents(__DIR__ . '/assets/space-travel.srt');
        $chunks = new Chunks($content);
        $chunks_array = $chunks->getChunks();
        $this->assertCount(4, $chunks_array);
        $this->assertTrue(strlen($chunks_array[0]) == 52);
        $this->assertTrue(strlen($chunks_array[1]) == 86);
        $this->assertTrue(strlen($chunks_array[2]) == 59);
        $this->assertTrue(strlen($chunks_array[3]) == 63);
    }
}
