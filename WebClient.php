<?php

class WebClient{
    
    
    function getServerResponse($serverURL){
        //(1)Retrieve contents
        $serverResponse = file_get_contents($serverURL);
        //(2)Decode contents
        $serverInfo = json_decode($serverResponse, true);
        //Return data
        return $serverInfo;
    }
}
?>