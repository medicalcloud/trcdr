<?php

class Calendar {
    private $episodes;
    public function __construct($episodes){
        #constructed by array of episodes
        $this->episodes = $episodes;
    }

    public function oneMonth($year, $month){
        #return array representing one month calendar
        #with this method, write monthly calendar html
    }

    public function oneYear($year){
        #return array representing one year calendar
        #with this method, write yearly calendar html
    }

    public function years($fromYear, $toYear){
        #return array representing years calendar
        #with this method, write long calendar html
    }

    public function addEpisode($episode){
        $this->episodes[] = $episode;
    }

    #public function removeEpisode($episode){
    #}

    public function episodes(){
        return $this->episodes;
    }

    public function setEspideos($episodes){
        $this->episodes = $episodes;
        return $this;
    }
}
