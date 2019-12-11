<?php  

    namespace ru\ivan_alone\simple_id3;

	abstract class AbstractID3Item {
		protected function chr($char_array) {
			if (!is_array($char_array)) {
				$char_array = [$char_array];
			}

			$res = '';

			foreach ($char_array as $char_id) {
				$res .= chr($char_id);
			}

			return $res;
		}

		protected function Ux00() {
			return $this->chr(0x00);
		}

		protected function Ux01() {
			return $this->chr(0x01);
		}

		protected function Ux0000() {
			return $this->chr([0x00, 0x00]);
		}

		protected function Ux0001() {
			return $this->chr([0x00, 0x01]);
		}

		protected function UxFFFE() {
			return $this->chr([0xFF, 0xFE]);
		}

		protected function UTF8_UTF16($utf8) {
			if ($utf8 == '') {
				return '';
			}

			$utf16 = $this->UxFFFE() . mb_convert_encoding($utf8, 'UCS-2LE', 'UTF-8');

			return $utf16;
		}

		public abstract function compile();

		public abstract static function parse(string $compiled);

		public function compileHex() {
			$res = $this->compile();

			$res2 = '';

			for ($i = 0; $i < strlen($res); $i++) {
				$res2 .= normalize(dechex(ord($res[$i])), 2) . ' ';
			}

			return strtoupper(trim($res2));
		}

		protected function normalizeLeft($value, $aim_length = 8, $symbol = '0') {
			while (strlen($value) < $aim_length) {
				$value = $symbol.$value;
			}
			return $value;
		}

		protected function normalizeRight($value, $aim_length = 8, $symbol = '0') {
			while (strlen($value) < $aim_length) {
				$value .= $symbol;
			}
			return $value;
		}

		protected function normalize($value, $aim_length = 8, $symbol = '0') {
			return $this->normalizeLeft($value, $aim_length, $symbol);
		}

        protected function id3_trim($word, $limit = 30) {
            return mb_substr($word, 0, $limit);
        }

        protected function id3_iconv($text) {
            return mb_convert_encoding($text, 'Windows-1251', 'UTF-8');
        }
	}
