<?php  

    namespace ru\ivan_alone\simple_id3\tags;

    class ImageID3Tag extends \ru\ivan_alone\simple_id3\AbstractID3Tag {
		private $mime_type, $description, $rawdata, $image_type;
		
		const JPEG = 'image/jpeg';
		const JPG = 'image/jpeg';
		const PNG = 'image/png';

		const OTHER = 0x00;
		const PNG_ICON_32 = 0x01;
		const OTHER_ICON = 0x02;
		const FRONT_COVER = 0x03;
		const BACK_COVER = 0x04;
		const LEAFLET_PAGE = 0x05;
		const MEDIA_LABLE = 0x06;
		const LEAD_ARTIST = 0x07;
		const ARTIST = 0x08;
		const CONDUCTOR = 0x09;
		const BAND = 0x0A;
		const COMPOSER = 0x0B;
		const TEXT_WRITER = 0x0C;
		const RECORDING_LOCATION = 0x0D;
		const DURING_RECORDING = 0x0E;
		const DURING_PERFORMANCE = 0x0F;
		const VIDEO_SCREEN_CAPTURE = 0x10;
		const BRIGHT_COLORED_FISH = 0x11;
		const ILLUSTRATION = 0x12;
		const ARTIST_LOGOTYPE = 0x13;
		const STUDIO_LOGOTYPE = 0x14;

		public function __construct($mime_type, $image_raw, $description = '', $image_type = ImageID3Tag::FRONT_COVER) {
			$this->mime_type = $mime_type;
			$this->rawdata = $image_raw;
			$this->image_type = $image_type;
			$this->description = $description;
		}

		public function getImageType() {
			return $this->image_type;
		}

		public function setImageType(int $image_type = ImageID3Tag::FRONT_COVER) {
			$this->image_type = $image_type;
		}

		public static function type() {
			return 'APIC';
		}

		public static function parse(string $compiled) {
			$encoding = ord(substr($compiled, 0, 1));

			$descr = '';
			$mime_type = '';

			$next = 1;
			while (($ch = ord(substr($compiled, $next++, 1))) !== 0) {
				$mime_type .= chr($ch);
			}
			
			$pic_type = ord(substr($compiled, $next++, 1));

			$charsize = $encoding == 1 ? 2 : 1;

			while (true) {
				$ch = substr($compiled, $next, $charsize);
				if (ord($ch[0]) == 0 && (strlen($ch) == 1 || ord($ch[1]) == 0)) {
					$next += $charsize;
					break;
				}
				$descr .= $ch;
				
				$next += $charsize;
			}

			return new static(
				$mime_type, 
				substr($compiled, $next), 
				mb_convert_encoding($descr, 'UTF-8', $encoding == 1 ? 'UTF-16' : 'ISO-8859-1'), 
				$pic_type
			);
		}

		public function getKey() {
			return $this->image_type;
		}

		public function getValue() {
			return $this->rawdata;
		}
		
		public function compile() {
			$res = $this->Ux00() . $this->mime_type . $this->Ux00() . $this->chr($this->image_type) . $this->id3_iconv($this->description) . $this->Ux00();
			//$res = $this->Ux01() . $this->mime_type . $this->Ux00() . $this->chr($this->image_type) . $this->UTF8_UTF16($this->description) . $this->Ux0000();
			$res .= $this->rawdata;
			
			return $this->createHeader($res, 0x0, 0x0) . $res;
		}
	}