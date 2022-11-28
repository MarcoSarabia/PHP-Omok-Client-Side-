<?php
include 'WebClient.php';
include 'Board.php';

class ConsoleUI{
    /* Prints out a message to che console
     * (1)Check is $newline is true or false
     *      if true, print message with a newline
     *      else, print message without a newline
     */
    function printMessage($message, $newline){
        //(1)Check value of $newline
        if($newline){
            //Print message with a newline
            echo $message."\n";
        }
        else{
            //Print message without a newline
            echo $message;
        }
    }
    
    
    /*Asks the user for a server URL and returns it, 
     *if its not formatted then it returns the defaule URL
     *(1)Promts the user to enter a URL in the console
     *(2)Check if the URL if empty:
     *  If empty then the default URL is printed to the console and returned 
     *  else the URL selected by the user is printed to the console and returned 
    */
    function promptServer($defaultURL){
        //(1)Print prompt
        $this->printMessage("Enter the server URL [Default: $defaultURL]", true);
        //Save input from user
        $userInput = readline();
        
        //(2)Check is input is empty or all whitespaces
        if(empty($userInput) || ctype_space($userInput)){
            //Print the default URL
            $this->printMessage("(Using: $defaultURL)", true);
            //Return the default URL
            return $defaultURL;
        }
        //Prints the URL given by the user
        $this->printMessage("(Using: $userInput)", true);
        //Returns teh URL given by the user
        return $userInput;
    }
    
    /*Promts the user to select a game strategy and returns it
     * (1)Define default selection as 1
     * (2)Prompt user to pick a strategy from the ones available in the server
     * (3)Check if the input is empty
     *      if empty: return the default strategy
     *      else, return strategy chosen by the user
     */
    function promptStrategy($strategies){
        //Define default selection
        $defaultSelection = 1;
        //Print basic message
        $this->printMessage("Select a strategy: ", false);
        
        //Cycle through strategies available in the server and print them
        $i = 1;
        foreach ($strategies as &$value){
            $this->printMessage("($i)$value ", false);
            $i++;
        }
        //Print default strategy
        $this->printMessage("[Default: $defaultSelection]", false);
       
        //Ask for user input
        $userInput = readline();
        
        //Check is input is empty or all whitespaces
        if(empty($userInput) || ctype_space($userInput)){
            return $strategies[$defaultSelection-1];
        }
        //Parse String $userInput into int $selectedStrategy and check for exceptions
        try{
            $selectedStrategy = (int)$userInput;
            return $strategies[$selectedStrategy-1];
            
        }catch(Exception $e){
            //Exception catched
            $this->printMessage("Error while parsing", true);
        }
    }
    
    /*Promts the user to enter their move and returns it
     *(1)Get user input
     *(2)Split it into array
     *(3)Return the array
     */
    function promptMove($boardsize){
        //(1)Promt the user to enter the coordinates
        $this->printMessage("Enter x and y (1-$boardsize, e.g, 8 10)", false);
        //(1)Get user input
        $userInput = readline();
        
        if(ctype_space($userInput) || strlen($userInput) < 3 || strlen($userInput) > 5){
            $this->printMessage("Sorry, your move is not well formatted", true);
            return null;
        }
        //(2)Save input into array
        $move = explode(" ", $userInput);
        //(3)Return array
        return $move;
    }
    
    /*Prints the cuerrently saved board
     * 
     */
    function printGameboard(Board $board, $boardSize){
        for($row = 0; $row < $boardSize + 2; $row++){
            for($col = 0; $col < $boardSize + 2; $col++){
                $this->printMessage($board->gameboard[$row][$col], false);
            }
            $this->printMessage("", true);
        }
        $this->printMessage("Player: O, Server: X (and *)", true);
    }
    
}

?>