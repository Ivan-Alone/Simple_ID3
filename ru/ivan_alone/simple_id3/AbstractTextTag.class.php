<?php  

    namespace ru\ivan_alone\simple_id3;

    abstract class AbstractTextTag extends AbstractID3Tag {
        protected $string;

        public function __construct($string) {
            $this->string = $string;
        } 

        public function compile() {
            $value = $this->Ux01() . $this->UTF8_UTF16($this->string);
            return $this->createHeader($value, 0x0, 0x0) . $value;
        }

        public function getValue(){
             return $this->string;
        }

        public static function parse(string $compiled) {
            $tag = new static(null);

            $charsetencodingdetector = ord(substr($compiled, 0, 1));
            $tag->string = mb_convert_encoding(substr($compiled, 1), 'UTF-8', $charsetencodingdetector == 1 ? 'UTF-16' : 'ISO-8859-1');

            return $tag;
        }
    }