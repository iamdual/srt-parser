<?php declare(strict_types=1);

namespace Iamdual\SrtParser\Tests;

use Iamdual\SrtParser\Chunks;
use PHPUnit\Framework\TestCase;

final class ChunksTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testChunks(): void
    {
        foreach (['lf', 'crlf', 'cr', 'fuzzed'] as $type) {
            $content = file_get_contents(__DIR__ . '/assets/sikidim-' . $type . '.srt');
            $chunks = new Chunks($content);
            $chunks_array = $chunks->getChunks();
            $this->assertCount(6, $chunks_array, "chunks_array count invalid on '$type'");
            $this->assertTrue(strlen($chunks_array[1]) == 80, "second chunk length invalid on '$type'");
        }
    }
}
