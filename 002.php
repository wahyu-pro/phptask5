<?php

class Movie{

    function indonesan_movies(){
        $url = "https://api.themoviedb.org/3/discover/movie?api_key=6ee5671a60dffcfba9b370c145061ef8&language=id-ID&region=ID&sort_by=popularity.asc&include_adult=false&include_video=false&page=1";
        $data = $this->http_request($url);
        $result = array_map(function($v){return($v["title"]);} , $data["results"]);
        print_r($result);
    }

    function playlist_by_keanu_reeves(){
        $url = "https://api.themoviedb.org/3/person/6384/movie_credits?api_key=6ee5671a60dffcfba9b370c145061ef8&language=en-US";
        $data = $this->http_request($url);
        $result = array_map(function($v){return($v["title"]);}, $data['cast']);
        print_r($result);
    }

    function played_by_robert_and_tom(){
        $robert = $this->play_by_robert_downey();
        $tom = $this->play_by_tom_holland();
        $result = array();
        foreach ($robert as $kr) {
            foreach ($tom as $tr) {
                if ($kr == $tr) {
                    array_push($result, $tr);
                }
            }
        }
        print_r($result);
    }

    function popular_movies(){
        $url = "https://api.themoviedb.org/3/discover/movie?api_key=6ee5671a60dffcfba9b370c145061ef8&language=en-US&sort_by=popularity.asc&include_adult=false&include_video=false&page=1&primary_release_year=2016&vote_count.gte=7.5";
        $data = $this->http_request($url);
        $result = array_map(function($v){return($v['title']);}, $data['results']);
        print_r($result);
    }

    function play_by_robert_downey(){
        $url = "https://api.themoviedb.org/3/person/3223/movie_credits?api_key=6ee5671a60dffcfba9b370c145061ef8&language=en-US";
        $data = $this->http_request($url);
        $result = array_map(function($v){return($v["title"]);}, $data['cast']);
        return $result;
    }

    function play_by_tom_holland(){
        $url = "https://api.themoviedb.org/3/person/1136406/movie_credits?api_key=6ee5671a60dffcfba9b370c145061ef8&language=en-US";
        $data = $this->http_request($url);
        $result = array_map(function($v){return($v["title"]);}, $data['cast']);
        return $result;
    }


    function http_request($url){
        // persiapkan curl
        $ch = curl_init();
        // set url
        curl_setopt($ch, CURLOPT_URL, $url);
        // return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string
        $output = curl_exec($ch);
        // tutup curl
        curl_close($ch);
        // decode hasil request
        $output = json_decode($output, true);
        // mengembalikan hasil curl
        return $output;
    }

}

$movie = new Movie();
$movie->indonesan_movies();
$movie->playlist_by_keanu_reeves();
$movie->played_by_robert_and_tom();
$movie->popular_movies();


?>