<?php  

    namespace ru\ivan_alone\simple_id3\tags;

    class CustomID3Tag extends \ru\ivan_alone\simple_id3\AbstractID3Tag {
		private $key, $value;

		public function __construct($key, $value) {
			$this->key = $key;
			$this->value = $value;
		} 

		public static function type() {
			return 'TXXX';
		}

        public function getValue() {
			return $this->value;
		}

        public function getKey() {
            return $this->key;
        }
		
		public function compile() {
			$value = $this->Ux01() . $this->UTF8_UTF16($this->key) . $this->Ux0000() . $this->UTF8_UTF16($this->value);
			return $this->createHeader($value, 0x0, 0x0) . $value;
		}
		
		public static function parse(string $compiled) {
			$charsetencodingdetector = ord(substr($compiled, 0, 1));

			$next = 1;
			$charsize = $charsetencodingdetector == 1 ? 2 : 1;
			$frame_key = '';
			while (true) {
				$ch = substr($compiled, $next, $charsize);
				if (ord($ch[0]) == 0 && (strlen($ch) == 1 || ord($ch[1]) == 0)) {
					$next += $charsize;
					break;
				}
				$frame_key .= $ch;
				
				$next += $charsize;
			}

			$frame_key = mb_convert_encoding($frame_key, 'UTF-8', $charsetencodingdetector == 1 ? 'UTF-16' : 'ISO-8859-1');
			$frame_value = explode(chr(0), mb_convert_encoding(substr($compiled, $next), 'UTF-8', $charsetencodingdetector == 1 ? 'UTF-16' : 'ISO-8859-1'));
			$frame_value = $frame_value[0];

			return new static($frame_key, $frame_value);
		}
	}