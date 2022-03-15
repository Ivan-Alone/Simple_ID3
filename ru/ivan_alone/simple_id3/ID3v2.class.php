<?php  

    namespace ru\ivan_alone\simple_id3;

    class ID3v2 extends AbstractID3Item {
		private $storage;

		private $version, $unsync_flag, $extended_flag, $experimental_flag, $size;

		public $parsedLenght;
		public function __construct() {
			$this->parsedLenght = 0;
			$this->storage = [];
		}

		public static function getTypeClass($type) {
			$map = [
				'TALB'=> 'AlbumID3Tag',
				'TPE2'=> 'AlbumPerformerID3Tag',
				'TBPM'=> 'BPMID3Tag',
				'COMM'=> 'CommentID3Tag',
				'TCOM'=> 'ComposerID3Tag',
				'TIT1'=> 'ContentGroupID3Tag',
				'TCOP'=> 'CopyrightMessageID3Tag',
				'TXXX'=> 'CustomID3Tag',
				'TENC'=> 'EncodedByID3Tag',
				'TFLT'=> 'FileTypeID3Tag',
				'TCON'=> 'GenreID3Tag',
				'APIC'=> 'ImageID3Tag',
				'TKEY'=> 'InitialKeyID3Tag',
				'TLAN'=> 'LanguageID3Tag',
				'TLEN'=> 'LengthID3Tag',
				'TMED'=> 'MediaTypeID3Tag',
				'TPE1'=> 'PerformerID3Tag',
				'TDLY'=> 'PlaylistDelayID3Tag',
				'TSRC'=> 'ISRCID3Tag',
				'TDAT'=> 'RecordingDateID3Tag',
				'TIME'=> 'RecordingTimeID3Tag',
				'TSSE'=> 'SoftwareID3Tag',
				'TIT3'=> 'SubtitleID3Tag',
				'TEXT'=> 'TextWriterID3Tag',
				'TIT2'=> 'TitleID3Tag',
				'TRCK'=> 'TrackNumberID3Tag',
				'TYER'=> 'YearID3Tag',
				'USLT'=> 'UnsyncedLyricsID3Tag'
			];
			$namespace = '\\ru\\ivan_alone\\simple_id3\\tags\\';
			foreach ($map as $tag => $class) {
				if ($tag == $type) {
					return $namespace . $class;
				}
			}
			return false;
		}

		public function push(AbstractID3Tag $value) {
			array_push($this->storage, $value);
		}

		public function pop() {
			return array_pop($this->storage);
		}

		public function unshift(AbstractID3Tag $value) {
			array_unshift($this->storage, $value);
		}

		public function shift() {
			return array_shift($this->storage);
		}

		public function flush() {
			$this->storage = [];
		}

		public function length() {
			return count($this->storage);
		}

		public function get(int $id) {
			if (!isset($this->storage[$id])) return null;

			return $this->storage[$id];
		} 

		public function purge(int $id) {
			$lst = [];
			foreach ($this->storage as $fd_id => $value) {
				if ($fd_id != $id) {
					array_push($lst, $value);
				}
			}
			$this->storage = $lst;
		}

		public function forEach(\Closure $callback) {
			foreach ($this->storage as $fd_id => $value) {
				$callback($fd_id, $value);
			}
		}

		public function toID3v1() {
			$id3v1 = new ID3v1();

			$flags = [
				false,
				false,
				false,
				false,
				false,
				false,
				false
			];

			foreach ($this->storage as $tag) {
				if ($tag instanceof \ru\ivan_alone\simple_id3\tags\AlbumID3Tag && !$flags[0]) {
					$id3v1->setAlbum($tag->getValue());
					$flags[0] = true;
				}
				if ($tag instanceof \ru\ivan_alone\simple_id3\tags\PerformerID3Tag && !$flags[1]) {
					$id3v1->setArtist($tag->getValue());
					$flags[1] = true;
				}
				if ($tag instanceof \ru\ivan_alone\simple_id3\tags\TitleID3Tag && !$flags[2]) {
					$id3v1->setTitle($tag->getValue());
					$flags[2] = true;
				}
				$id3v1->setGenre(255);
				if ($tag instanceof \ru\ivan_alone\simple_id3\tags\GenreID3Tag && !$flags[3]) {
					preg_match('#^\(([0-9]+)\)$#', $tag->getValue(), $found);
					if (@$found[1] == (string)(int)@$found[1]) {
						$id3v1->setGenre((int)@$found[1]);
						$flags[3] = true;
					}
				}
				if ($tag instanceof \ru\ivan_alone\simple_id3\tags\CommentID3Tag && !$flags[4]) {
					$id3v1->setComment($tag->getComment());
					$flags[4] = true;
				}
				if ($tag instanceof \ru\ivan_alone\simple_id3\tags\TrackNumberID3Tag && !$flags[5]) {
					$id3v1->setTrackNumber($tag->getNumber());
					$flags[5] = true;
				}
				if ($tag instanceof \ru\ivan_alone\simple_id3\tags\YearID3Tag && !$flags[6]) {
					$id3v1->setYear($tag->getValue());
					$flags[6] = true;
				}
			}

			return $id3v1;
		}

		public function compile() {
			if (count($this->storage) == 0) {
				return '';
			}
			
			$val = '';
			$flags_int = 0x00;
			$res = 'ID3' . $this->chr([0x03, 0x00, $flags_int]);
			foreach ($this->storage as $frame) {
				$val .= $frame->compile();
			}

			$len = strlen($val);
			for ($i = 3; $i >= 0; $i--) {
				$res .= chr( ( $len & (0x7F * pow(0x80, $i)) ) >> ($i * 7) );
			}

			$res .= $val;

			return $res;
		}

		public static function parse(string $compiled) {
			$id3v2 = new static();

			$possible_header = substr($compiled, 0, 10);

			if (strlen($possible_header) < 10 || substr($possible_header, 0, 3) != 'ID3') {
				return false;
			}

			$v = (int)ord($possible_header[3]);
			if ($v == 0xFF) {
				return false;
			}
			$v = $v . '.'.(int)ord($possible_header[4]);

			$flags_byte = $id3v2->normalize(decbin((int)ord($possible_header[5])));
			if (substr($flags_byte, 3) != '00000') {
				return false;
			}

			$unsync = $flags_byte[0] == '1';
			$ext = $flags_byte[1] == '1';
			$exp = $flags_byte[2] == '1';

			$size = '';

			for ($i = 0; $i < 4; $i++) {
				$size_byte = $id3v2->normalize(decbin((int)ord($possible_header[6+$i])));
				$size .= substr($size_byte, 1);
			}

			$size = bindec($size);

			if ($size == 0) {
				$id3v2->parsedLenght = 10;
				return $id3v2->parsedLenght;
			}

			$id3v2->parsedLenght = $size + 10;
			$id3v2->size = $size;

			$id3v2->version = $v;
			$id3v2->unsync_flag = $unsync;
			$id3v2->extended_flag = $ext;
			$id3v2->experimental_flag = $exp;

			$data = substr($compiled, 10, $id3v2->size);
			$fpointer = 0;

			while ($fpointer < $id3v2->size) {

				$frame_header = substr($data, $fpointer, 10);

				if ($frame_header == '') {
					break;
				}

				if (ord(substr($frame_header, 0, 1)) == 0) {
					break;
				}


				$frame_title = substr($frame_header, 0, 4);
				$frame_size = 0;

				for ($i = 0; $i < 4; $i++) {
					$frame_size += ord($frame_header[4+$i]) << (8 * (3 - $i));
				}

				$rawtext = substr($data, $fpointer + 10, $frame_size);

				$class = ID3v2::getTypeClass($frame_title);

				if ($class == null) {
					echo '[Warning] Tag "' . $frame_title . '" is not implemented yet, so it will be lost after writing MP3!'.PHP_EOL;
				} else {
					$tag = $class::parse($rawtext);
					if ($tag instanceof AbstractID3Tag) {
						$id3v2->push($tag);
					}
				}
				
				$fpointer += 10 + $frame_size;
			}

			return $id3v2;
		}
	}
