<?php

class Time_Span {

    private $_current_time;
    private $_symbols = array(

        'd' => '日',
        'h' => '時間',
        'm' => '分',
        's' => '秒',
        'a' => '前'

    );

    public function __construct() {

        $this->_current_time = time();

    }

    public function setSymbols($symbols) {

        $this->_symbols = $symbols;

    }

    public function getTimeSpan($target_time, $ago_display=true) {

        $return = '';

        if($target_time <= 0) return '0'. $this->_symbols['m'];

        $term_mode = $this->getTermMode($target_time);
        $gap_time = $this->getGapTime($target_time);
        
        switch($term_mode) {

            case 'd':
                $return = round($gap_time/86400) . $this->_symbols['d'];
                break;
            case 'h':
                $return = round($gap_time/3600) . $this->_symbols['h'];
                break;
            case 'm':
                $return = round($gap_time/60) . $this->_symbols['m'];
                break;
            default:
                $return = $gap_time . $this->_symbols['s'];
                break;

        }

        if($ago_display) {

            $return .= $this->_symbols['a'];

        }

        return $return;

    }

    public function getTermMode($target_time) {

        $return = '';
        $gap_time = $this->getGapTime($target_time);

        if($gap_time >= 86400) {

            $return = 'd';

        } else if($gap_time >= 3600) {

            $return = 'h';

        } else if($gap_time >= 60) {

            $return = 'm';

        } else {

            $return = 's';

        }
        
        return $return;

    }

    private function getGapTime($target_time) {

        return $this->_current_time - $target_time;

    }

}

/*** Sample Source

    require('time_span.php');

    $ts = new Time_Span();
    echo $ts->getTimeSpan(1269891211);

***/
