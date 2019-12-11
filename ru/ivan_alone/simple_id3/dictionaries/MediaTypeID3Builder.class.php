<?php 

    namespace ru\ivan_alone\simple_id3\dictionaries;

    class MediaTypeID3Builder extends \ru\ivan_alone\simple_id3\AbstractID3Item {
        private $type, $subtypes, $readonly;

        private function __construct() {
            $this->readonly = false;
            $this->type = 'DIG';
            $this->subtypes = [];
        }

        public static function create() {
            return new static();
        }

        public function build() {
            $this->readonly = true;
            return $this;
        }

        public function setDigitalType() {
            if ($this->readonly) return $this;
             
            $this->type = 'DIG';
            return $this;
        }
        public function addAnalogTransferSubtype() {
            if ($this->readonly) return $this;
             
            switch ($this->type) {
                case 'DIG':
                case 'CD':
                case 'LD':
                case 'MD':
                case 'DAT':
                case 'DCC':
                case 'DVD':
                    array_push($this->subtypes, 'A');
                    break;
                default:
            }
            return $this;
        }
        
        public function setAnalogType() {
            if ($this->readonly) return $this;
             
            $this->type = 'ANA';
            return $this;
        }
        public function addWaxCylinderSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'ANA') {
                array_push($this->subtypes, 'WAX');
            }
            return $this;
        }
        public function add8TrackTapeCasseteSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'ANA') {
                array_push($this->subtypes, '8CA');
            }
            return $this;
        }

        public function setCDType() {
            if ($this->readonly) return $this;
             
            $this->type = 'CD';
            return $this;
        }
        public function addDDDSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'CD') {
                array_push($this->subtypes, 'DD');
            }
            return $this;
        }
        public function addADDSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'CD') {
                array_push($this->subtypes, 'AD');
            }
            return $this;
        }
        public function addAADSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'CD') {
                array_push($this->subtypes, 'AA');
            }
            return $this;
        }

        public function setLaserDiskType() {
            if ($this->readonly) return $this;
             
            $this->type = 'LD';
            return $this;
        }

        public function setTurnableRecordsType() {
            if ($this->readonly) return $this;
             
            $this->type = 'TT';
            return $this;
        }
        public function add33RPMSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'TT') {
                array_push($this->subtypes, '33');
            }
            return $this;
        }
        public function add45RPMSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'TT') {
                array_push($this->subtypes, '45');
            }
            return $this;
        }
        public function add71RPMSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'TT') {
                array_push($this->subtypes, '71');
            }
            return $this;
        }
        public function add76RPMSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'TT') {
                array_push($this->subtypes, '76');
            }
            return $this;
        }
        public function add78RPMSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'TT') {
                array_push($this->subtypes, '78');
            }
            return $this;
        }
        public function add80RPMSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'TT') {
                array_push($this->subtypes, '80');
            }
            return $this;
        }
        
        public function setMiniDiskType() {
            if ($this->readonly) return $this;
             
            $this->type = 'MD';
            return $this;
        }
        
        public function setDATType() {
            if ($this->readonly) return $this;
             
            $this->type = 'DAT';
            return $this;
        }
        public function addStandartModeSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'DAT') {
                array_push($this->subtypes, '1');
            }
            return $this;
        }
        public function add2ModeSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'DAT') {
                array_push($this->subtypes, '2');
            }
            return $this;
        }
        public function add3ModeSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'DAT') {
                array_push($this->subtypes, '3');
            }
            return $this;
        }
        public function add4ModeSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'DAT') {
                array_push($this->subtypes, '4');
            }
            return $this;
        }
        public function add5ModeSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'DAT') {
                array_push($this->subtypes, '5');
            }
            return $this;
        }
        public function add6ModeSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'DAT') {
                array_push($this->subtypes, '6');
            }
            return $this;
        }
        
        public function setDCCType() {
            if ($this->readonly) return $this;
             
            $this->type = 'DCC';
            return $this;
        }
        
        public function setDVDType() {
            if ($this->readonly) return $this;
             
            $this->type = 'DVD';
            return $this;
        }

        public function setTVType() {
            if ($this->readonly) return $this;
             
            $this->type = 'TV';
            return $this;
        }
        public function addPALModeSubtype() {
            if ($this->readonly) return $this;
             
            switch ($this->type) {
                case 'TV':
                case 'VID':
                    array_push($this->subtypes, 'PAL');
                    break;
                default:
            }
            return $this;
        }
        public function addNTSCModeSubtype() {
            if ($this->readonly) return $this;
             
            switch ($this->type) {
                case 'TV':
                case 'VID':
                    array_push($this->subtypes, 'NTSC');
                    break;
                default:
            }
            return $this;
        }
        public function addSECAMModeSubtype() {
            if ($this->readonly) return $this;
             
            switch ($this->type) {
                case 'TV':
                case 'VID':
                    array_push($this->subtypes, 'SECAM');
                    break;
                default:
            }
            return $this;
        }

        public function setVideoType() {
            if ($this->readonly) return $this;
             
            $this->type = 'VID';
            return $this;
        }
        public function addVHSSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'VID') {
                array_push($this->subtypes, 'VHS');
            }
            return $this;
        }
        public function addSVHSSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'VID') {
                array_push($this->subtypes, 'SVHS');
            }
            return $this;
        }
        public function addBETAMAXSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'VID') {
                array_push($this->subtypes, 'BETA');
            }
            return $this;
        }

        public function setRadioType() {
            if ($this->readonly) return $this;
             
            $this->type = 'RAD';
            return $this;
        }
        public function addFMSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'RAD') {
                array_push($this->subtypes, 'FM');
            }
            return $this;
        }
        public function addAMSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'RAD') {
                array_push($this->subtypes, 'AM');
            }
            return $this;
        }
        public function addLWSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'RAD') {
                array_push($this->subtypes, 'LW');
            }
            return $this;
        }
        public function addMWSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'RAD') {
                array_push($this->subtypes, 'MW');
            }
            return $this;
        }

        public function setTelephoneType() {
            if ($this->readonly) return $this;
             
            $this->type = 'TEL';
            return $this;
        }
        public function addISDNSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'TEL') {
                array_push($this->subtypes, 'I');
            }
            return $this;
        }
        
        public function setCompactCasseteType() {
            if ($this->readonly) return $this;
             
            $this->type = 'MC';
            return $this;
        }
        public function add4_75CMCasseteSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'MC') {
                array_push($this->subtypes, '4');
            }
            return $this;
        }
        public function add9_5CMCasseteSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'MC') {
                array_push($this->subtypes, '');
            }
            return $this;
        }
        public function addNormalCasseteSubtype() {
            if ($this->readonly) return $this;
             
            switch ($this->type) {
                case 'MC':
                case 'REE':
                    array_push($this->subtypes, 'I');
                default:
            }
            return $this;
        }
        public function addChromeCasseteSubtype() {
            if ($this->readonly) return $this;
             
            switch ($this->type) {
                case 'MC':
                case 'REE':
                    array_push($this->subtypes, 'II');
                default:
            }
            return $this;
        }
        public function addFerricChromeCasseteSubtype() {
            if ($this->readonly) return $this;
             
            switch ($this->type) {
                case 'MC':
                case 'REE':
                    array_push($this->subtypes, 'III');
                default:
            }
            return $this;
        }
        public function addMetalCasseteSubtype() {
            if ($this->readonly) return $this;
             
            switch ($this->type) {
                case 'MC':
                case 'REE':
                    array_push($this->subtypes, 'IV');
                default:
            }
            return $this;
        }
        
        public function setReelType() {
            if ($this->readonly) return $this;
             
            $this->type = 'REE';
            return $this;
        }
        public function add9_5cmsCasseteSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'REE') {
                array_push($this->subtypes, '9');
            }
            return $this;
        }
        public function add19cmsCasseteSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'REE') {
                array_push($this->subtypes, '19');
            }
            return $this;
        }
        public function add38cmsCasseteSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'REE') {
                array_push($this->subtypes, '38');
            }
            return $this;
        }
        public function add76cmsCasseteSubtype() {
            if ($this->readonly) return $this;
             
            if ($this->type == 'REE') {
                array_push($this->subtypes, '76');
            }
            return $this;
        }

		public function compile() {
            return '(' . $this->type . (count($this->subtypes) == 0  ? '' : '/' . implode('/', $this->subtypes)) . ')';
        }

		public static function parse(string $compiled) {
            return false;
        }
    }