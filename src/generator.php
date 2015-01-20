<?php
namespace src;

require 'Board.php';

class Maze
{
    public function initialize()
    {
        //create a board to house the maze
        $board = new Board();
        $board->generateMaze();
    }

    protected function writeMaze()
    {

    }

    protected function startBlock()
    {

    }

    protected function endBlock()
    {

    }

    protected function createBoard()
    {

    }
}

$maze = new Maze();

$maze->initialize();