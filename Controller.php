<?php
//Include classes to use them as objects
include 'ConsoleUI.php';

//Default URL
$defaultURL = "https://www.cs.utep.edu/cheon/cs3360/project/omok/info/";

//Initialize intances of the View and Model
$console = new ConsoleUI();
$webClient = new WebClient();

//Welcome message
$console->printMessage("Welcome to Omok Game!", true);



//Promt the user for the server's URL
$serverURL = $console->promptServer($defaultURL);



//Message to let the user know the program is working on getting the game's info
$console->printMessage("Obtaining server information...", true);
//Get response from server
$serverInfo = $webClient->getServerResponse($serverURL);
//Save the board size
$boardSize = $serverInfo["size"];
//Save the strategies available
$gameStrategies = $serverInfo["strategies"];



//Prompt a strategy from the user
$selectedStrategy = $console->promptStrategy($gameStrategies);
//Let the user know a new game is being created
$console->printMessage("Creating new game ($selectedStrategy)...", true);



//(1)Substract unneeded part from the URL in use
$newURL = substr($serverURL, 0, -5);
//(1)Add needed path to the URL
$newURL .= "new/?strategy=$selectedStrategy";
//Get response from server
$serverInfo = $webClient->getServerResponse($newURL);



//(3)Check if server's response is false
if(!$serverInfo["response"]){
    //Reponse is false, print message to user and return null
    $console->printMessage("False response from server: ${serverInfo["reason"]}", true);
    exit();
}



//Response is true, save the pid
$pid = $serverInfo["pid"];



//Create board
$board = new Board();



//Save base URL for the play function
$playURLBase = substr($serverURL, 0, -5);
$playURLBase .= "play/?";



//Print gameBoard for the first time
$console->printGameboard($board, $boardSize);


/*This loop takes take of:
 * (1)Asking for the user's move 
 * (2)Displaying the user's move
 * (3)Ask fo server's move
 * (4)Display the server's move
 * (5)Check if anyone won the game
 * 
 */
while(true){ 
    //Prompt the user for a move
    $userMove = $console->promptMove($boardSize);
    
    //Check if the user's move is well formatted
    if(is_null($userMove)){
        exit();
    }
    
    //Convert string coordinates into int coordinates
    $x = (int)$userMove[0]-1;
    $y = (int)$userMove[1]-1;
    
    //Place user's move (latest)
    $board->gameboard[$x+2][$y+2] = "*O";
    //Print gameBoard with user's move
    $console->printGameboard($board, $boardSize);
    //Update gameboard
    $board->gameboard[$x+2][$y+2] = " O";
    
    
    
    //(1)Add needed path to the URL
    $playURL = $playURLBase."pid=$pid&move=$x,$y";
    //Get response from server
    $serverInfo = $webClient->getServerResponse($playURL);
    
    
    
    //Check for false response from server
    if(!$serverInfo["response"]){
        //Reponse is false, print message to user and return null
        $console->printMessage("False response from server: ${serverInfo["reason"]}", true);
        
        if($serverInfo["reason"] == "Pid not specified" || $serverInfo["reason"] == "Unknown pid"){
            exit();
        }
        continue;
    }
    
    
    
    //Check if user won
    if($serverInfo["ack_move"]["isWin"]){
        $console->printMessage("You won!!", true);
        
        $board->gameboard[$serverInfo["ack_move"]["row"][0]+2][$serverInfo["ack_move"]["row"][1]+2] = " W";
        $board->gameboard[$serverInfo["ack_move"]["row"][2]+2][$serverInfo["ack_move"]["row"][3]+2] = " W";
        $board->gameboard[$serverInfo["ack_move"]["row"][4]+2][$serverInfo["ack_move"]["row"][5]+2] = " W";
        $board->gameboard[$serverInfo["ack_move"]["row"][6]+2][$serverInfo["ack_move"]["row"][7]+2] = " W";
        $board->gameboard[$serverInfo["ack_move"]["row"][8]+2][$serverInfo["ack_move"]["row"][9]+2] = " W";
        
        //Print gameBoard with server's move
        $console->printGameboard($board, $boardSize);
        break;
    }
    
    
    
    //Place server's move
    $board->gameboard[$serverInfo["move"]["x"]+2][$serverInfo["move"]["x"]+2] = "*X";
    //Print gameBoard with server's move
    $console->printGameboard($board, $boardSize);
    
    
    
    //Check if server won
    if($serverInfo["move"]["isWin"]){
        $console->printMessage("You lost:(", true);
        
        $board->gameboard[$serverInfo["move"]["row"][0]+2][$serverInfo["move"]["row"][1]+2] = " L";
        $board->gameboard[$serverInfo["move"]["row"][2]+2][$serverInfo["move"]["row"][3]+2] = " L";
        $board->gameboard[$serverInfo["move"]["row"][4]+2][$serverInfo["move"]["row"][5]+2] = " L";
        $board->gameboard[$serverInfo["move"]["row"][6]+2][$serverInfo["move"]["row"][7]+2] = " L";
        $board->gameboard[$serverInfo["move"]["row"][8]+2][$serverInfo["move"]["row"][9]+2] = " L";
        
        //Print gameBoard with server's move
        $console->printGameboard($board, $boardSize);
        break;
    }
    
    
    
    //Update gameboard
    $board->gameboard[$serverInfo["move"]["x"]+2][$serverInfo["move"]["x"]+2] = " X";
}










?>