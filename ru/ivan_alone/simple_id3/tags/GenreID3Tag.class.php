<?php  
    
    namespace ru\ivan_alone\simple_id3\tags;

    class GenreID3Tag extends \ru\ivan_alone\simple_id3\AbstractTextTag {
        public function __construct($genre) {
            $test = (int)$genre;
            $genre = (string)$test == $genre ? '(' . $test . ')' : ((substr($genre, 0, 1) == '(' ? '(' : '') . $genre);
            parent::__construct($genre);
        } 

        public static function type() {
            return 'TCON';
        }
        
        public static function parse(string $compiled) {
            $charsetencodingdetector = ord(substr($compiled, 0, 1));
            
            $tag = new static('');
            $tag->string = mb_convert_encoding(substr($compiled, 1), 'UTF-8', $charsetencodingdetector == 1 ? 'UTF-16' : 'ISO-8859-1');

            return $tag;
        }
    }