<?php  

namespace ru\ivan_alone\simple_id3\tags;

class FileTypeID3Tag extends \ru\ivan_alone\simple_id3\AbstractTextTag {
    const MPEG = 'MPG';
    const MP1 = '/1';
    const MP2 = '/2';
    const MP3 = '/3';
    const MP_2_5 = '/2.5';
    const AAC = '/AAC';
    const VQF = 'VQF';
    const PCM = 'PCM';

    public function __construct($filetype = FileTypeID3Tag::MP3) {
        parent::__construct($filetype);
    } 
    
    public static function type() {
        return 'TFLT';
    }
}