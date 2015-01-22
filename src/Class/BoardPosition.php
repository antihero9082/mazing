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
    //todo: get affected cells and check them - exit if : cell is not valid, cell is revisited, or destination cell is visited AND in between cell is not (so we dont make squares);
    public function moveLeft($spaces = 1)
    {
        $destination = $this->xPos - $spaces;
        if ($this->board->getValidCell($this->xPos - $spaces, $this->yPos)
            &&
            ('RV' !== $this->board->getCellValue($destination, $this->yPos))
            && //If the next cell is not visited AND the following next cell is visited, leave a wall
            ($this->board->getCellValue($destination, $this->yPos) != Board::NOTOUCH)
        ) {
            for ($i = 1; $i < $spaces; $i++) {
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
        $destination = $this->xPos + $spaces;
        if ($this->board->getValidCell($this->xPos + $spaces, $this->yPos)
            &&
            'RV' !== $this->board->getCellValue($destination, $this->yPos)
        ) {
            for ($i = 1; $i < $spaces; $i++) {
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
        $destination = $this->yPos - $spaces;
        if ($this->board->getValidCell($this->xPos, $destination)
            &&
            'RV' !== $this->board->getCellValue($this->xPos, $destination)
        ) {
            for ($i = 1; $i < $spaces; $i++) {
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
        $destination = $this->yPos + $spaces;
        if ($this->board->getValidCell($this->xPos, $destination)
            &&
            'RV' !== $this->board->getCellValue($this->xPos, $destination)
        ) {
            for ($i = 1; $i < $spaces; $i++) {
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
