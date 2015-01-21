<?php
namespace src;
require_once 'Position.php';

class BoardPosition extends Position
{
    protected $board;

    protected $lastMove;

    public function __construct(Board $board, $xPos = 0, $yPos = 0)
    {
        $this->xPos = $xPos;
        $this->yPos = $yPos;
        $this->board = $board;
    }

    public function moveLeft($spaces = 1)
    {
        if ($this->board->getValidCell($this->xPos - $spaces, $this->yPos)) {
            //check board for revisited cells
            $destination = $this->xPos-$spaces;
            if ('RV' !== $this->board->getValidCell($destination, $this->yPos)) {

            }
            for ($i = 0; $i < $spaces; $i++) {
                $this->board->markBoard($this->xPos - $i, $this->yPos);
            }
            $this->lastMove = 'moveLeft';
            $this->xPos = $this->xPos-$spaces;
            $this->markCurrent();
            return true;
        }

        return false;
    }

    public function moveRight($spaces = 1)
    {
        if ($this->board->getValidCell($this->xPos + $spaces, $this->yPos)) {
            for ($i = 0; $i < $spaces; $i++) {
                $this->board->markBoard($this->xPos + $i, $this->yPos);
            }
            $this->lastMove = 'moveRight';
            $this->xPos = $this->xPos + $spaces;
            $this->markCurrent();
            return true;
        }

        return false;
    }

    public function moveUp($spaces = 1)
    {
        if ($this->board->getValidCell($this->xPos, $this->yPos - $spaces)) {
            for ($i = 0; $i < $spaces; $i++) {
                $this->board->markBoard($this->xPos, $this->yPos - $i);
            }
            $this->lastMove = 'moveUp';
            $this->yPos = $this->yPos - $spaces;
            $this->markCurrent();
            return true;
        }
        return false;
    }

    public function moveDown($spaces = 1)
    {
        if ($this->board->getValidCell($this->xPos, $this->yPos + $spaces)) {
            for ($i = 0; $i < $spaces; $i++) {
                $this->board->markBoard($this->xPos, $this->yPos + $i);
            }
            $this->yPos = $this->yPos + $spaces;
            $this->lastMove = 'moveDown';
            $this->markCurrent();
            return true;
        }
        return false;
    }

    /**
     * @param \src\Board $board
     */
    public function setBoard($board)
    {
        $this->board = $board;
    }

    /**
     * @return \src\Board
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * @param mixed $lastMove
     */
    public function setLastMove($lastMove)
    {
        $this->lastMove = $lastMove;
    }

    /**
     * @return mixed
     */
    public function getLastMove()
    {
        return $this->lastMove;
    }

    /**
     * marks current board position
     */
    private function markCurrent()
    {
        $this->board->markBoard($this->xPos, $this->yPos);
    }
}
