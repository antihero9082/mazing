<?php
namespace src;
require_once 'Position.php';

class BoardPosition extends Position
{
    protected $board;

    protected $lastMove;

    protected $previousSpace;

    public function __construct(Board $board, $xPos = 0, $yPos = 0)
    {
        $this->xPos = $xPos;
        $this->yPos = $yPos;
        $this->board = $board;
    }
    //todo: figure out backtrack, so revisit cells and nevar go back
    public function moveLeft($spaces = 1)
    {
        $destination = $this->xPos - $spaces;
        if ($destination < 0) {
            return false;
        }
        if ($this->board->getValidCell($destination, $this->yPos)
            &&
            (Board::REVISITED !== $this->board->getCellValue($destination, $this->yPos)) //this is fine
            && //If the next cell is not visited AND the destination next cell is visited, leave a wall
            $this->checkAffectedCells('left', $destination, $spaces)
        ) {
            for ($i = 1; $i < $spaces; $i++) {
                $this->board->markBoard($this->xPos - $i, $this->yPos);
            }
            $this->lastMove = 'moveLeft';
            $this->previousSpace = 'moveRight';
            $this->xPos = $this->xPos-$spaces;
            $this->markCurrent();
            return true;
        }
        return false;
    }

    public function moveRight($spaces = 1)
    {
        $destination = $this->xPos + $spaces;
        if ($destination > $this->board->getWidth() - 1) {
            return false;
        }
        if ($this->board->getValidCell($this->xPos + $spaces, $this->yPos)
            &&
            Board::REVISITED !== $this->board->getCellValue($destination, $this->yPos)
            &&
            $this->checkAffectedCells('right', $destination, $spaces)
        ) {
            for ($i = 1; $i < $spaces; $i++) {
                $this->board->markBoard($this->xPos + $i, $this->yPos);
            }
            $this->lastMove = 'moveRight';
            $this->previousSpace = 'moveLeft';
            $this->xPos = $this->xPos + $spaces;
            $this->markCurrent();
            return true;
        }

        return false;
    }

    public function moveUp($spaces = 1)
    {
        $destination = $this->yPos - $spaces;
        if ($destination < 0) {
            return false;
        }
        if ($this->board->getValidCell($this->xPos, $destination)
            &&
            Board::REVISITED !== $this->board->getCellValue($this->xPos, $destination)
            &&
            $this->checkAffectedCells('up', $destination, $spaces)
        ) {
            for ($i = 1; $i < $spaces; $i++) {
                $this->board->markBoard($this->xPos, $this->yPos - $i);
            }
            $this->lastMove = 'moveUp';
            $this->previousSpace = 'moveDown';
            $this->yPos = $this->yPos - $spaces;
            $this->markCurrent();
            return true;
        }

        return false;
    }

    public function moveDown($spaces = 1)
    {
        $destination = $this->yPos + $spaces;
        if ($destination > $this->board->getHeight() - 1) {
            return false;
        }
        if ($this->board->getValidCell($this->xPos, $destination)
            &&
            Board::REVISITED !== $this->board->getCellValue($this->xPos, $destination)
            &&
            $this->checkAffectedCells('down', $destination, $spaces)
        ) {
            for ($i = 1; $i < $spaces; $i++) {
                $this->board->markBoard($this->xPos, $this->yPos + $i);
            }
            $this->yPos = $this->yPos + $spaces;
            $this->lastMove = 'moveDown';
            $this->previousSpace = 'moveUp';
            $this->markCurrent();
            return true;
        }

        return false;
    }

    /**
     * @return Array
     */
    protected function checkAffectedCells($movement, $destination, $spaces)
    {
        if ($spaces <= 1) {
            return true; //no other affected cells
        }

        $cells = [];
        switch($movement) {
            case 'left':
                $cells[] = $this->board->getCellValue($destination, $this->yPos);
                for ($i = 1; $i < $spaces; $i++) {
                    $cells[] = $this->board->getCellValue($this->xPos - $i, $this->yPos);
                }
                break;
            case 'right':
                if ($destination > $this->board->getWidth() -1) {
                    return false;
                }
                $cells[] = $this->board->getCellValue($destination, $this->yPos);
                for ($i = 1; $i < $spaces; $i++) {
                    $cells[] = $this->board->getCellValue($this->xPos + $i, $this->yPos);
                }
                break;
            case 'up':
                $cells[] = $this->board->getCellValue($this->xPos, $destination);
                for ($i = 1; $i < $spaces; $i++) {
                    $cells[] = $this->board->getCellValue($this->xPos, $this->yPos - $i);
                }
                break;
            case 'down':
                $cells[] = $this->board->getCellValue($this->xPos, $destination);
                for ($i = 1; $i < $spaces; $i++) {
                    $cells[] = $this->board->getCellValue($this->xPos, $this->yPos + $i);
                }
                break;
        }
        if (in_array(Board::NOTOUCH, $cells)
           &&
           (in_array(Board::VISITED, $cells) || in_array(Board::REVISITED, $cells)) //both are in affected, leave wall
        ) {
            return false; //Leave the wall and break
        }

        return true;
    }

    protected function checkCell(array $cells)
    {

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

    /**
     * @param mixed $previousSpace
     */
    public function setPreviousSpace($previousSpace)
    {
        $this->previousSpace = $previousSpace;
    }

    /**
     * @return mixed
     */
    public function getPreviousSpace()
    {
        return $this->previousSpace;
    }
}
