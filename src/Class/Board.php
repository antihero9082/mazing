<?php
namespace src;


class Board
{
    const NOTOUCH = 'N';
    const VISITED = 'V';
    const REVISITED = 'RV';

    /** @var  int width */
    protected $width;

    /** @var  int $height */
    protected $height;

    /** @var  array $currentState */
    protected $currentState;

    public function __construct($width = 40, $height = 40)
    {
        $this->width = $width;
        $this->height = $height;
        $currentState = [];
        for ($w = 0; $w < $this->width; $w++) {
            for ($h = 0; $h < $this->height; $h++) {
                $currentState[$w][] = $h;
            }
        }
        $this->currentState = $currentState;
    }

    /**
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    public function getValidCell($width, $height)
    {
        if ($width <= $this->width && $height <= $this->height) {
            return true;
        }

        return false;
    }

    public function toArray()
    {
        return [$this->width, $this->height];
    }

    public function markBoard($width, $height)
    {
        $boardCell = &$this->currentState[$width][$height];
        if ($boardCell == 'N') {
            $boardCell = 'V';
        } elseif ($boardCell == 'V') {
            $boardCell = 'RV';
        }
    }

    public function getTotalCells()
    {
        return $this->width * $this->height;
    }

    public function printBoard()
    {   ob_start();
        $this->write(ob_get_clean());
    }

    private function write($str)
    {
        $handle = fopen('test', 'a');
        if (!$handle) {
            die('nofilez =[[[');
        } else {
            fwrite($handle, $str);
        }
        fclose($handle);
    }
}
