<?php  

    namespace ru\ivan_alone\simple_id3\tags;

    class CommentID3Tag extends \ru\ivan_alone\simple_id3\AbstractID3Tag {
        private $lang, $description, $text;

        public function __construct($lang, $description, $text) {
            $this->setLang($lang);
            $this->setDescription($description);
            $this->setComment($text);
        }

        public static function type() {
            return 'COMM';
        }

        public function compile() {
            $value = $this->Ux01() . $this->lang . $this->UTF8_UTF16($this->description) . $this->Ux0000() . $this->UTF8_UTF16($this->text);
            return $this->createHeader($value, 0x0, 0x0) . $value;
        }

        public function getValue() {
            return $this->text;
        }

        public function getComment() {
            return $this->text;
        }
        public function setComment($text) {
            $this->text = $text;
        }

        public function getDescription() {
            return $this->description;
        }
        public function setDescription($description) {
            $this->description = $description;
        }

        public function getLang() {
            return $this->lang;
        }
        public function setLang($lang) {
            $this->lang = substr($lang, 0, 3);
        }

        public static function parse(string $compiled) {
            $charsetencodingdetector = ord(substr($compiled, 0, 1));

            $lang = substr($compiled, 1, 3);

            $next = 4;
            $charsize = $charsetencodingdetector == 1 ? 2 : 1;
            $description = '';
            while (true) {
                $ch = substr($compiled, $next, $charsize);
                if (ord($ch[0]) == 0 && (strlen($ch) == 1 || ord($ch[1]) == 0)) {
                    $next += $charsize;
                    break;
                }
                $description .= $ch;
                
                $next += $charsize;
            }

            $comment = explode(chr(0), mb_convert_encoding(substr($compiled, $next), 'UTF-8', $charsetencodingdetector == 1 ? 'UTF-16' : 'ISO-8859-1'));
            $comment = $comment[0];
            
            return new static($lang, $description, $comment);
        }
    }