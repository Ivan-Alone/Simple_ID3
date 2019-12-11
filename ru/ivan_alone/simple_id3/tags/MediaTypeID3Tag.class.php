<?php  

    namespace ru\ivan_alone\simple_id3\tags;

    use \ru\ivan_alone\simple_id3\dictionaries\MediaTypeID3Builder as MediaTypeID3Builder;

    class MediaTypeID3Tag extends \ru\ivan_alone\simple_id3\AbstractTextTag {
        public function __construct($media_type) {
            parent::__construct($media_type instanceof MediaTypeID3Builder ? $media_type->compile() : ((substr($media_type, 0, 1) == '(' ? '(' : '') . $media_type));
        }
        
		public static function type() {
			return 'TMED';
		}
    }