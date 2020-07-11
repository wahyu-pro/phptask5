<?php

class Combine{

    function combine(){
        $post = $this->http_request("https://jsonplaceholder.typicode.com/posts");
        $users = $this->http_request("https://jsonplaceholder.typicode.com/users");
        $result = [];
        foreach ($post as $po) {
            foreach ($users as $user) {
                if ($po['userId'] == $user['id']) {
                    $po["user"] = $user;
                }
            }
            array_push($result, $po);
        }

        // save to json
        $filename = "results.json";
        $open_file = fopen($filename, "a+");
        $string = json_encode($result, JSON_PRETTY_PRINT);
        fwrite($open_file, $string);
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

$combine = new Combine();
$combine->combine();

?>