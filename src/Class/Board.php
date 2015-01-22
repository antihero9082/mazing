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

    private $runtime;

    public function __construct($width = 40, $height = 40)
    {
        $this->runtime = new \DateTime();
        $this->width = $width;
        $this->height = $height;
        $currentState = [];
        for ($w = 0; $w < $this->width; $w++) {
            for ($h = 0; $h < $this->height; $h++) {
                $currentState[$w][$h] = self::NOTOUCH;
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

    public function getCellValue($width, $height)
    {
        return $this->currentState[$width][$height];
    }

    public function setCellValue($width, $height, $value)
    {
        return $this->currentState[$width][$height] = $value;
    }

    public function toArray()
    {
        return [$this->width, $this->height];
    }

    public function markBoard($xPos, $yPos)
    {
        $boardCell = &$this->currentState[$xPos][$yPos];
        if ($boardCell == 'N') {
            $boardCell = '?';
        } elseif ($boardCell == '?') {
            $boardCell = '.';
        }
    }

    public function getTotalCells()
    {
        return $this->width * $this->height;
    }

    public function printBoard()
    {   ob_start();
        for ($w = 0; $w < $this->width; $w++) {
            for ($h = 0; $h < $this->height; $h++) {
                echo($this->getCellValue($w, $h));
            }
            echo "\n";
        }
        echo "\n======================================\n";
        $this->write(ob_get_clean());
    }

    private function write($str)
    {
        $handle = fopen(sprintf('Draw/test-%s', $this->runtime->format('c')), 'a');
        if (!$handle) {
            die('nofilez =[[[');
        } else {
            fwrite($handle, $str);
        }
        fclose($handle);
    }
}
