<?php
include 'Board.php';

class WebClient{
    //Default URL for the game service
    static $defaultURL = "https://www.cs.utep.edu/cheon/cs3360/project/omok/info/";
    //Array containing game strategies available in the game service
    static $gameStrategies;
    
    function getServerResponse($serverURL){
        //(1)Retrieve contents
        $serverResponse = file_get_contents($serverURL);
        //(2)Decode contents
        $serverInfo = json_decode($serverResponse, true);
        //Return data
        return $serverInfo;
    }
    
    /* Gets the game's information from the server
     * (1)Takes the server URL
     * (2)Retrieves response from server and decodes it
     * (3)Saves the size and the strategies given by the server
    */
    function getGameInfo($serverURL){
        //(2)Retrieve contents
        $serverResponse = file_get_contents($serverURL);
        //(2)Decode contents
        $serverInfo = json_decode($serverResponse, true);
            
        //(3)Save the size
        Board::$boardSize = $serverInfo["size"];
        //(3)Save the strategies
        WebClient::$gameStrategies = $serverInfo["strategies"]; 
    }
    
    /* Requests to create a new game from the server 
     * (1)Takes the current server URL and replaces it with the version needed to request
     *    a new Game
     * (2)Retrieves response from server and decodes it
     * (3)Checks if the server sent a false response; 
     *      if response is false then returns null
     *      if response true then returns the unique pid given by the server
     */
    function requestNewGame($serverURL, $strategy){
        //(1)Substract unneeded part from the URL in use
        $serverURL = substr($serverURL, 0, -5);
        //(1)Add needed path to the URL
        $serverURL .= "new/?strategy=$strategy";
        
        //(2)Retrieve contents 
        $serverResponse = file_get_contents($serverURL);
        //(2)Decode contents
        $serverInfo = json_decode($serverResponse, true);
        
        //(3)Check if server's response is false
        if(!$serverInfo["response"]){
            //Reponse is false, print message to user and return null
            echo "False response from server: ${serverInfo["reason"]}";
            return null;
        }
        //Response is true, return the game pid
        return $serverInfo["pid"];
    }
    
    function requestMove($serverURL, $pid, $x, $y){
        //(1)Substract unneeded part from the URL in use
        $serverURL = substr($serverURL, 0, -5);
        //(1)Add needed path to the URL
        $serverURL .= "play/?pid=$pid&move=$x,$y";
        
        //(2)Retrieve contents
        $serverResponse = file_get_contents($serverURL);
        //(2)Decode contents
        $serverInfo = json_decode($serverResponse, true);
    }
    
}


?>