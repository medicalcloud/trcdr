<?php

class Calendar {
    private $episodes; #array from date to episode
    public function __construct($episodes){
        #constructed by array of episodes
        $this->setEpisodes($episodes);
    }

    public function EpisodesInPeriod($startDay, $endDay){
        #範囲に含まれるepisodeの配列を返す
        #episodeにはinPeriodがあるので、Viewでこれを順にコールして
        #カレンダーを書く。
        $episodesInPeriod = [];
        foreach($this->episodes as $episode){
            if($episode->inPeriod($startDay, $endDay)){
                $episodesInPeriod[] = $epidode;
            }
        }
        return $episodesInPeriod;
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
