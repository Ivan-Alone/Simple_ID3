<?php  

namespace ru\ivan_alone\simple_id3\tags;

class RecordingTimeID3Tag extends \ru\ivan_alone\simple_id3\AbstractID3Tag {
    private $minute, $hour;

    public function __construct(int $hour, int $minute) {
        parent::__construct('TIME');
        $this->hour = min(max(0, $hour), 23);
        $this->minute = min(max(0, $minute), 59);
    } 

    public function getValue(){
         return [
             'hour' => $this->day,
             'minute' => $this->month
         ];
    }

    public function compile() {
        $val = $this->normalize($this->hour, 2) . $this->normalize($this->minute, 2);
        return $this->createHeader($val, 0x0, 0x0) . $val;
    }

    public static function parse(string $compiled) {
        
    }
}