<?php  

    namespace ru\ivan_alone\simple_id3\tags;

    class LengthID3Tag extends \ru\ivan_alone\simple_id3\AbstractTextTag {
		public function __construct($millis) {
			parent::__construct((string)(int)$millis);
		} 
		public static function type() {
			return 'TLEN';
		}
	}