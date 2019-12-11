<?php  

namespace ru\ivan_alone\simple_id3\tags;

class PlaylistDelayID3Tag extends \ru\ivan_alone\simple_id3\AbstractTextTag {
    public function __construct($bpm) {
        parent::__construct((string)(int)$bpm);
    } 
    public static function type() {
        return 'TDLY';
    }
}