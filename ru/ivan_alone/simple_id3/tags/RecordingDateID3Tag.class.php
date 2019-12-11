<?php  

namespace ru\ivan_alone\simple_id3\tags;

class RecordingDateID3Tag extends \ru\ivan_alone\simple_id3\AbstractID3Tag {
    private $day, $month;

    public function __construct(int $day, int $month) {
        parent::__construct('TDAT');
        $this->day = min(max(1, $day), 31);
        $this->month = min(max(1, $month), 12);
    } 

    public function getValue(){
         return [
             'day' => $this->day,
             'month' => $this->month
         ];
    }

    public function compile() {
        $val = $this->normalize($this->day, 2) . $this->normalize($this->month, 2);
        return $this->createHeader($val, 0x0, 0x0) . $val;
    }

    public static function parse(string $compiled) {

    }
}