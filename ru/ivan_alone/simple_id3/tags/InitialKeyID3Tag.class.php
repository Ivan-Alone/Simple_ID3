<?php  

namespace ru\ivan_alone\simple_id3\tags;

class InitialKeyID3Tag extends \ru\ivan_alone\simple_id3\AbstractTextTag {
    public function __construct($initial_key) {
        $key = '';

        $allowed = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'b', '#', 'm', 'o'];

        $initial_key = substr($initial_key, 0, 3);
        for ($i = 0; $i < 3; $i++) {
            if (in_array($initial_key[$i], $allowed)) {
                $key .= $initial_key[$i];
            }
        }
        parent::__construct($initial_key);
    } 
    public static function type() {
        return 'TKEY';
    }
}