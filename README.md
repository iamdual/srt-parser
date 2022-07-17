# Iamdual\SrtParser

Yet another SRT (SubRip text) parser library written in PHP 8.

## Installing
```bash
composer require iamdual/srt-parser
```

## Usage
```php
$parser = SrtParser::fromFile(__DIR__ . '/MrRobot.srt');
foreach ($parser->getSubtitles() as $subtitle) {
    echo $subtitle->getContent();
}
```

Instead of facade, you can use subclasses for advanced purposes.
```php
$content = file_get_contents(__DIR__ . '/MrRobot.srt');
$chunks = new Chunks($content);
foreach ($chunks->getChunks() as $chunk) {
    $parser = new SubtitleParser($chunk);
    try {
        $subtitle = $parser->getSubtitle();
        var_dump($subtitle);
    } catch (SyntaxErrorException $e) {
        echo 'Error! ' . $e->getMessage();
        continue;
    }
}
```

## More information
- https://en.wikipedia.org/wiki/SubRip#SubRip_file_format

## Author
- Ekin Karadeniz (iamdual@icloud.com)