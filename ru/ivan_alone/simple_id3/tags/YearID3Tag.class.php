<?php  

namespace ru\ivan_alone\simple_id3\tags;

class YearID3Tag extends \ru\ivan_alone\simple_id3\AbstractTextTag {
    public function __construct($year) {
        parent::__construct((string)(int)$year);
    } 
    public static function type() {
        return 'TYER';
    }
}