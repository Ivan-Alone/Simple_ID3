<?php  

    namespace ru\ivan_alone\simple_id3\tags;

    class LanguageID3Tag extends \ru\ivan_alone\simple_id3\AbstractTextTag {
        public function __construct($language) {
            parent::__construct(substr($language, 0, 3));
        } 

        public static function type() {
            return 'TLAN';
        }
    }