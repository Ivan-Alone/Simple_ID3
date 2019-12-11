<?php  

namespace ru\ivan_alone\simple_id3\tags;

class TrackNumberID3Tag extends \ru\ivan_alone\simple_id3\AbstractTextTag {
    private $number, $trackMax;
    
    public function __construct(int $track, int $trackMax = 0) {
        parent::__construct(((string)$track) . ($trackMax > 0 ? '/' . (string)$trackMax : ''));
        $this->number = $track;
        $this->trackMax = $trackMax;
    }
    
    public static function type() {
        return 'TRCK';
    }

    public function getNumber() {
        return $this->number;
    }
    
    public function getMaxCount() {
        return $this->trackMax;
    }
    public static function parse(string $compiled) {
        $charsetencodingdetector = ord(substr($compiled, 0, 1));
        $text = mb_convert_encoding(substr($compiled, 1), 'UTF-8', $charsetencodingdetector == 1 ? 'UTF-16' : 'ISO-8859-1');

        $text = explode('/', $text);

        return new static((int)$text[0], count($text) > 1 ? $text[1] : 0);
    }
}