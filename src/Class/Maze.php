<?php
namespace src;

require 'Board.php';
require 'BoardPosition.php';

class Maze
{

    protected $board;

    protected $position;

    public function __construct($width = 40, $height = 30)
    {
        $this->board = new Board($width, $height);
        $this->position = new BoardPosition($this->board);
    }

    public function generateMaze()
    {
        $ended = false;
        $i = 0 ;
        while (!$ended) {
            $position = $this->makeMove($this->position);
            if ($position->getXPos() == $this->board->getWidth() -1 && $position->getYPos() == $this->board->getHeight()-1) {
                $ended = true;
                echo $i;
            }
            $i++;
            //$this->printBoard();
        }
        $this->currentState[$this->width-1][$this->height-1] = 'f';
        echo ('zomgboardprint'."\n");
    }

    /**
     * @param Position $currentPosition
     * @param array $exclude
     * @return Position $position
     */
    protected function makeMove(BoardPosition $currentPosition)
    {
        $legalMoves = $this->getLegalMoves($currentPosition);
        if (empty($legalMoves)) {
            //if no legal moves best move backwards
            $legalMoves = $this->getLegalMoves($currentPosition);
        }
        $position = $currentPosition->{$legalMoves[mt_rand(0, count($legalMoves) - 1)]}(2);


        return $currentPosition;
    }

    //todo : randomize move and check legality (no moving on a revisited cell)
    protected function getLegalMoves(BoardPosition $position)
    {
        $availableFunctions = [];
        if ($position->getXPos() > 0 && $position->getLastMove() !== 'moveRight') { //can  move left
            $availableFunctions[] = 'moveLeft';
        }
        if ($position->getXPos() < $this->board->getWidth() && $position->getLastMove() !== 'moveLeft') {
            $availableFunctions[] = 'moveRight';
        }
        if ($position->getYPos() > 0 && $position->getLastMove() !== 'moveDown') {
            $availableFunctions[] = 'moveUp';
        }
        if ($position->getYPos() < $this->board->getHeight() && $position->getLastMove() !== 'moveUp') {
            $availableFunctions[] = 'moveDown';
        }

        return $availableFunctions;
    }
}