<?php  

    namespace ru\ivan_alone\simple_id3\tags;

    use \ru\ivan_alone\simple_id3\dictionaries\Languages as Languages;

    class UnsyncedLyricsID3Tag extends \ru\ivan_alone\simple_id3\AbstractID3Tag {
		private $lang, $description, $text;

		public function __construct($text, $lang = Languages::ENGLISH, $description = '') {
            $this->setText($text);
            $this->setLanguage($lang);
            $this->setDescription($description);
		} 

		public static function type() {
			return 'USLT';
		}

        public function getValue() {
            return $this->text;
        }
        
        public function getLanguage() {
            return $this->lang;
        }
        
        public function setLanguage($lang) {
            $this->lang = substr($lang, 0, 3);
        }
        
        public function getDescription() {
            return $this->description;
        }
        
        public function setDescription($text) {
            $this->description = $text;
        }
        
        public function getText() {
            return $this->text;
        }
        
        public function setText($text) {
            $this->text = $text;
        }
		
		public function compile() {
			$value = $this->Ux01() . $this->lang . $this->UTF8_UTF16($this->description) . $this->Ux0000() . $this->UTF8_UTF16($this->text);
			return $this->createHeader($value, 0x0, 0x0) . $value;
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

            $text = explode(chr(0), mb_convert_encoding(substr($compiled, $next), 'UTF-8', $charsetencodingdetector == 1 ? 'UTF-16' : 'ISO-8859-1'));
            $text = $text[0];
            
            return new static($text, $lang, $description);
        }
	}