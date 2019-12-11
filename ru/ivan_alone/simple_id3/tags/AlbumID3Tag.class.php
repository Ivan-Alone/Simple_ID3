<?php  

    namespace ru\ivan_alone\simple_id3\tags;

    class AlbumID3Tag extends \ru\ivan_alone\simple_id3\AbstractTextTag {
		public static function type() {
			return 'TALB';
		}
	}