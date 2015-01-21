<?php
namespace src;

abstract class Position
{
    /**
     * @var int
     */
    protected $xPos;

    /**
     * @var int
     */
    protected $yPos;

    /**
     * Maybe someday...
     * @var int
     */
    protected $zPos;

    /**
     * Contruct with 0 positions
     */
    public function __construct()
    {
        $this->xPos = 0;
        $this->yPos = 0;
    }

    /**
     * @param mixed $xPos
     */
    public function setXPos($xPos)
    {
        $this->xPos = $xPos;
    }

    /**
     * @return mixed
     */
    public function getXPos()
    {
        return $this->xPos;
    }

    /**
     * @param mixed $yPos
     */
    public function setYPos($yPos)
    {
        $this->yPos = $yPos;
    }

    /**
     * @return mixed
     */
    public function getYPos()
    {
        return $this->yPos;
    }

    public function moveLeft($spaces = 1)
    {
        $this->xPos = $this->xPos-$spaces;
    }

    public function moveRight($spaces = 1)
    {
        $this->xPos = $this->xPos+$spaces;
    }

    public function moveUp($spaces = 1)
    {
        $this->yPos = $this->yPos-$spaces;
    }

    public function moveDown($spaces = 1)
    {
        $this->yPos = $this->yPos+$spaces;
    }

    public function toArray()
    {
        return [$this->xPos, $this->yPos];
    }
}
