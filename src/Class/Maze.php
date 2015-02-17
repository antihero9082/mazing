<?php
namespace src;

require 'Board.php';
require 'BoardPosition.php';

class Maze
{

    protected $board;

    protected $position;

    public function __construct($width = 20, $height = 20)
    {
        $this->board = new Board($width, $height);
        $this->position = new BoardPosition($this->board);
    }

    public function generateMaze()
    {
        $ended = false;
        $i = 0 ;
        $this->board->markBoard(0, 0);
        while (!$ended) {
            $position = $this->makeMove($this->position);
            if ($position->getXPos() == $this->board->getWidth() -1 && $position->getYPos() == $this->board->getHeight()-1 || $i > 10000) {
                $ended = true;
                echo $i;
            }
            $i++;
        }
        $this->board->printBoard();
        echo ('zomgboardprint'."\n");
    }

    /**
     * @param Position $currentPosition
     * @param array $exclude
     * @return Position $position
     */
    protected function makeMove(BoardPosition $currentPosition, $exclude = [])
    {
        $legalMoves = $this->getLegalMoves($currentPosition, $exclude);
        if (empty($legalMoves)) {
            //if no legal moves best move backwards
            $currentPosition->{$currentPosition->getPreviousSpace()}(2);
        } else {
            $move = $legalMoves[mt_rand(0, count($legalMoves) - 1)];
            if (!$currentPosition->{$move}(2)) { //if the move returns false, it has failed
                $exclude[] = $move;
                return $this->makeMove($currentPosition, $exclude);
            }
        }



        return $currentPosition;
    }

    //todo : randomize move and check legality (no moving on a revisited cell)
    protected function getLegalMoves(BoardPosition $position, $exclude = [])
    {
        $availableFunctions = [];
        if ($position->getXPos() > 0 && $position->getLastMove() !== 'moveRight') { //can  move left
            $availableFunctions[] = 'moveLeft';
        }
        if ($position->getXPos() < $this->board->getWidth() && $position->getLastMove() !== 'moveLeft') {
            $availableFunctions[] = 'moveRight';
        }
        if ($position->getYPos() > 0 &&  $position->getLastMove() !== 'moveDown') {
            $availableFunctions[] = 'moveUp';
        }
        if ($position->getYPos() < $this->board->getHeight() &&  $position->getLastMove() !== 'moveUp') {
            $availableFunctions[] = 'moveDown';
        }
        foreach ($exclude as $name) {
            $key = array_search($name, $availableFunctions);
            if (false !== $key) {
                unset($availableFunctions[$key]);
            }
        }

        return array_values($availableFunctions);
    }
}