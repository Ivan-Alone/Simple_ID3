<?php

    namespace ru\ivan_alone\simple_id3;

    class MP3 {
        private $id3, $rawmusicdata, $filename;

        private function __construct() {
        }

        public function getFileName() {
            return $this->filename;
        }

        public function setFileName($filename) {
            $this->filename = $filename;
        }

        public function getTags() {
            return $this->id3;
        }

        public function write() {
            file_put_contents($this->filename, $this->build());
        }

        public function build() {
            return $this->id3->compile() . $this->rawmusicdata;
        }

        public static function load($filename) {
            if (!file_exists($filename)) return false;
            $mp3 = static::loadData(file_get_contents($filename));
            if ($mp3 instanceof MP3) {
                $mp3->filename = $filename;
                return $mp3;
            }
            return false;
        }

        public static function loadData($file) {
            $mp3 = new MP3();

            $possible_tag = $mp3->detectID3v1($file);

            if ($possible_tag != null) {
                $mp3->id3 = ID3v1::parse($possible_tag)->toID3v2();
            }
            
            if (substr($file, 0, 3) == 'ID3') {
                $mp3->id3 = ID3v2::parse($file);
                $file = substr($file, $mp3->id3->parsedLenght);
            } else {
                $mp3->id3 = new ID3v2();
            }

            $mp3->rawmusicdata = $file;

            return $mp3;
        }

        private function detectID3v1(&$rawfile) {
            $tagfinder = substr($rawfile, -128);
            if (substr($tagfinder, 0, 3) == 'TAG') {
                $rawfile = substr($rawfile, 0, -128);
                return $tagfinder;
            }
        }
    }