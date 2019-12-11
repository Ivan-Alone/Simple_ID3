<?php

    namespace ru\ivan_alone\simple_id3;

    use \ru\ivan_alone\simple_id3\dictionaries\Languages as Languages;

    class ID3v1 extends AbstractID3Item  {
        private $album, $artist, $genre, $title, $comment, $number, $year;

        public function __construct() {

        }

        private function enc($text, $len = 30) {
            return $this->normalizeRight($this->id3_iconv($text), $len, chr(0));
        }

        public function getAlbum() {
            return $this->album;
        }
        public function setAlbum(string $album) {
            $this->album = $this->id3_trim($album);
        }

        public function getArtist() {
            return $this->artist;
        }
        public function setArtist(string $artist) {
            $this->artist = $this->id3_trim($artist);
        }

        public function getGenre() {
            return $this->genre;
        }
        public function setGenre(int $genre) {
            $this->genre = max(min(255, $genre), 0);
        }

        public function setTitle(string $title) {
            $this->title = $this->id3_trim($title);
            
        }

        public function getComment() {
            return $this->comment;
        }
        public function setComment(string $comment) {
            $this->comment = $this->id3_trim($comment, 28);
        }

        public function getTrackNumber() {
            return $this->number;
        }
        public function setTrackNumber(int $num) {
            $this->number = max(min(255, $num), 1);
        }

        public function getYear() {
            return $this->year;
        }
        public function setYear(int $year) {
            $this->year = max(min(9999, $year), -999);
        }

        public function compile() {
            return 'TAG' . 
            $this->enc($this->title) . 
            $this->enc($this->artist) . 
            $this->enc($this->album) . 
            $this->enc((string)$this->year, 4) . 
            $this->enc($this->comment, 28) . 
            chr(0) . 
            chr($this->number) . 
            chr($this->genre);
        }

        public function toID3v2() {
            $id3v2 = new ID3v2();
            
            if ($this->album != null) {
                $id3v2->push(new \ru\ivan_alone\simple_id3\tags\AlbumID3Tag($this->album));
            }
            if ($this->artist != null) {
                $id3v2->push(new \ru\ivan_alone\simple_id3\tags\PerformerID3Tag($this->artist));
            }
            if ($this->title != null) {
                $id3v2->push(new \ru\ivan_alone\simple_id3\tags\TitleID3Tag($this->title));
            }
            if ($this->genre != null) {
                $id3v2->push(new \ru\ivan_alone\simple_id3\tags\GenreID3Tag($this->genre));
            }
            if ($this->comment != null) {
                $id3v2->push(new \ru\ivan_alone\simple_id3\tags\CommentID3Tag(Languages::ENGLISH, '', $this->comment));
            }
            if ($this->number != null) {
                $id3v2->push(new \ru\ivan_alone\simple_id3\tags\TrackNumberID3Tag($this->number));
            }
            if ($this->year != null) {
                $id3v2->push(new \ru\ivan_alone\simple_id3\tags\YearID3Tag($this->year));
            }

            return $id3v2;
        }

        public static function parse(string $compiled) {
            $id3 = new static();



            return $id3;
        }

        
    }