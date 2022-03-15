<?php

    namespace ru\ivan_alone\simple_id3\tags;

    class ISRCID3Tag extends \ru\ivan_alone\simple_id3\AbstractTextTag {
	public function __construct($tag) {
		$tag = substr($tag, 0, 12);
		parent::__construct($tag);
	}
        public static function type() {
            return 'TSRC';
        }
    }
