<?php

class Board{
    public $gameboard;
    
    function __construct(){
        $this->gameboard = array(
            array(" ", "x"," 1", " 2"," 3", " 4"," 5", " 6"," 7", " 8"," 9", " 0"," 1", " 2", " 3", " 4", " 5"),
            array("y", " ","--", "--","--", "--","--", "--","--", "--","--", "--","--", "--", "--", "--", "--"),
            array("1", "|"," -", " -", " -", " -", " -", " -"," -", " -"," -", " -"," -", " -", " -", " -", " -"),
            array("2", "|"," -", " -", " -", " -", " -", " -"," -", " -"," -", " -"," -", " -", " -", " -", " -"),
            array("3", "|"," -", " -", " -", " -", " -", " -"," -", " -"," -", " -"," -", " -", " -", " -", " -"),
            array("4", "|"," -", " -", " -", " -", " -", " -"," -", " -"," -", " -"," -", " -", " -", " -", " -"),
            array("5", "|"," -", " -", " -", " -", " -", " -"," -", " -"," -", " -"," -", " -", " -", " -", " -"),
            array("6", "|"," -", " -", " -", " -", " -", " -"," -", " -"," -", " -"," -", " -", " -", " -", " -"),
            array("7", "|"," -", " -", " -", " -", " -", " -"," -", " -"," -", " -"," -", " -", " -", " -", " -"),
            array("8", "|"," -", " -", " -", " -", " -", " -"," -", " -"," -", " -"," -", " -", " -", " -", " -"),
            array("9", "|"," -", " -", " -", " -", " -", " -"," -", " -"," -", " -"," -", " -", " -", " -", " -"),
            array("0", "|"," -", " -", " -", " -", " -", " -"," -", " -"," -", " -"," -", " -", " -", " -", " -"),
            array("1", "|"," -", " -", " -", " -", " -", " -"," -", " -"," -", " -"," -", " -", " -", " -", " -"),
            array("2", "|"," -", " -", " -", " -", " -", " -"," -", " -"," -", " -"," -", " -", " -", " -", " -"),
            array("3", "|"," -", " -", " -", " -", " -", " -"," -", " -"," -", " -"," -", " -", " -", " -", " -"),
            array("4", "|"," -", " -", " -", " -", " -", " -"," -", " -"," -", " -"," -", " -", " -", " -", " -"),
            array("5", "|"," -", " -", " -", " -", " -", " -"," -", " -"," -", " -"," -", " -", " -", " -", " -"),
        );
    }
}
?>