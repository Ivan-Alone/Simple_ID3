<?php  

    namespace ru\ivan_alone\simple_id3;

	abstract class AbstractID3Tag extends AbstractID3Item {
		private $flagInt1, $flagInt2;

		public function __construct() {
			$this->flagInt1 = 0;
			$this->flagInt2 = 0;
		}

        protected static abstract function type();

		public function setTagAlterPreserve(boolean $dontsave) {
			$this->flagInt1 = 
				(($dontsave ? 1 : 0) << 7) | ((($this->flagInt1 >> 6) & 1) << 6) | ((($this->flagInt1 >> 5) & 1) << 5);
		}

		public function setFileAlterPreserve(boolean $dontsave) {
			$this->flagInt1 = 
				(($this->flagInt1 >> 7) << 7) | (($dontsave ? 1 : 0) << 6) | ((($this->flagInt1 >> 5) & 1) << 5);
		}

		public function setReadonly(bool $readonly) {
			$this->flagInt1 = 
				(($this->flagInt1 >> 7) << 7) | ((($this->flagInt1 >> 6) & 1) << 6) | (($readonly ? 1 : 0) << 5);
		}

		public function setCompressed(boolean $compressed) {
			$this->flagInt2 = 
				(($compressed ? 1 : 0) << 7) | ((($this->flagInt2 >> 6) & 1) << 6) | ((($this->flagInt2 >> 5) & 1) << 5);
		}

		public function setEncryption(boolean $encrypted) {
			$this->flagInt2 = 
				(($this->flagInt2 >> 7) << 7) | (($encrypted ? 1 : 0) << 6) | ((($this->flagInt2 >> 5) & 1) << 5);
		}

		public function setInGroup(bool $inGroup) {
			$this->flagInt2 = 
				(($this->flagInt2 >> 7) << 7) | ((($this->flagInt2 >> 6) & 1) << 6) | (($inGroup ? 1 : 0) << 5);
		}

        public abstract function getValue();

        public function getKey() {
            return $this->type();
        }

        public final function getRealKey() {
            return $this->type();
        }

		protected function createHeader($value, $flagint1, $flagint2) {
			$size = '';
			$len = strlen($value);

			for ($i = 3; $i >= 0; $i--) {
				$size .= chr( ( $len & (0xFF * pow(0x100, $i)) ) >> ($i * 8) );
			}
			return $this->type() . $size . chr($this->flagInt1) . chr($this->flagInt2);
		}
	}