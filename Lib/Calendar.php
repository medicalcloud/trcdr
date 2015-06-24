<?php

class Calendar {
    private $episodes; #array from date to episode
    public function __construct($episodes){
        #constructed by array of episodes
        $this->setEpisodes($episodes);
    }

    public function episodesOnCalendar($startDay, $endDay){
        #範囲に含まれるepisodeの配列を返す
        #episodeにはinPeriodがあるので、Viewでこれを順にコールして
        #カレンダーを書く。
        $episodesOnCalendar = [];
        foreach($this->episodes as $episode){
            if($episode->onCalendar($startDay, $endDay)){
                $episodesOnCalendar[] = $epidode;
            }
        }
        return $episodesOnCalendar;
    }

    public function days($startDay, $endDay){
        #二重配列返す
        if(is_string($startDay)){
            $startDay = new DateTime($startDay);
        }
        if(is_string($endDay)){
            $endDay = new DateTime($endDay);
        }
        $calendar = [];
        $header = [];$header[] = '';
        for($day = clone $startDay; $day->modify('+1 day'); $endDay <= $day){
                $header[] = clone $day;
        }
        $calendar[] = $header;

        $episodes = $this->episodesOnCalendar($startDay, $endDay);
        foreach($episodes as $episode){
            $line = []; $line[] = $episode;
            for($day = clone $startDay; $day->modify('+1 day'); $endDay <= $day){
                $header[] = $episode->onCalendar($day, $day);
            }
            $calendar[] = $line;
        }
        return $calendar;
    }
    
    public function monthes($startDay, $endDay){
        #二重配列返す
        if(is_string($startDay)){
            $startDay = new DateTime($startDay);
        }
        if(is_string($endDay)){
            $endDay = new DateTime($endDay);
        }
        $calendar = [];
        $header = [];$header[] = '';
        for($day = clone $startDay, $day->modify('twelfth day of this month')
            ; $day->modify('+1 month'); $endDay <= $day){
                $copiedDay = clone $day;
            }
        $calendar[] = $header;

        $episodes = $this->episodesOnCalendar($startDay, $endDay);
        foreach($episodes as $episode){
            $line = []; $line[] = $episode;
            for($day = clone $startDay, $day->modify('twelfth day of this month')
                ; $day->modify('+1 month'); $endDay <= $day){
                $firstDay = clone $day; $firstDay->modify('first day of this month');
                $lastDay = clone $day; $lastDay->modify('last day of this month');
                $header[] = $episode->onCalendar($firstDay, $lastDay);
            }
            $calendar[] = $line;
        }
        return $calendar;
    }

    public function years($startDay, $endDay){
        #二重配列返す
        if(is_string($startDay)){
            $startDay = new DateTime($startDay);
        }
        if(is_string($endDay)){
            $endDay = new DateTime($endDay);
        }
        $calendar = [];
        $header = [];$header[] = '';
        for($day = clone $startDay, $day->modify('twelfth day of this year')
            ; $day->modify('+1 year'); $endDay <= $day){
                $copiedDay = clone $day;
            }
        $calendar[] = $header;

        $episodes = $this->episodesOnCalendar($startDay, $endDay);
        foreach($episodes as $episode){
            $line = []; $line[] = $episode;
            for($day = clone $startDay, $day->modify('twelfth day of this year')
                ; $day->modify('+1 year'); $endDay <= $day){
                $firstDay = clone $day; $firstDay->modify('first day of this year');
                $lastDay = clone $day; $lastDay->modify('last day of this year');
                $header[] = $episode->onCalendar($firstDay, $lastDay);
            }
            $calendar[] = $line;
        }
        return $calendar;
    }



    public function oneMonth($month){
        #week毎に区切った配列を返す
    }

    public function addEpisode($episode){
        $this->episodes[] = $episode;
    }

    #public function removeEpisode($episode){
    #}

    public function episodes(){
        return $this->episodes;
    }

    public function setEpisodes($episodes){
        $this->episodes = $episodes;
        return $this;
    }
}
