<?php
namespace src;


class Board
{
    const NOTOUCH = null;
    const UNVISITED = false;
    const VISITED = true;

    /** @var  int width */
    protected $width;
    /** @var  int $height */
    protected $height;
    /** @var  array $currentState */
    protected $currentState;

    public function __construct($width = 20, $height = 20)
    {
        $this->width = $width;
        $this->height = $height;
        $this->board = imagecreate($width, $height);
        $this->createBoard();
    }

    /**
     * @param int $width
     */
    public function setColumns($width)
    {
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getColumns()
    {
        return $this->width;
    }

    /**
     * @param int $height
     */
    public function setRows($height)
    {
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getRows()
    {
        return $this->height;
    }

    public function generateMaze()
    {
        //here we go, well say starting point is 0,0 (or [0][0])
        $position = ['x' => 0, 'y' => 0];
        $this->currentState[0][0] = 's';
        $ended = false;
        $i = 0 ;
        while (!$ended) {
            $position = $this->makeMove($position);
            if ($position['x'] == $this->width-1 && $position['y'] == $this->height-1) {
                $ended = true;
                echo $i;
            }
            $i++;
            $this->printBoard();
        }
        $this->currentState[$this->width-1][$this->height-1] = 'f';
        echo ('zomgboardprint'."\n");
    }

    public function printBoard()
    {   ob_start();
        foreach ($this->currentState as $wideIndex => $heightIndex) {
            foreach ($heightIndex as $h => $visited) {
                if ($visited==false) {
                    echo "h";
                } else {
                    echo "T";
                }
            }
            echo "\n";
        }
        echo "\n";
        $this->write(ob_get_clean());
    }

    protected function moveUp($position)
    {
        //decrement y position
        $newPosition = [];
        $newPosition['y'] = $position['y']-2;
        $newPosition['x'] = $position['x'];

        //check current position for statuses, if its open, we can move up, else, return current position;
        if ($position['y'] < 1 || ($newPosition['y']+1 !== self::NOTOUCH && $newPosition['y'] === self::VISITED)) {
            return $this->makeMove($position, ['moveUp']); //cant move up
        }
        $this->currentState[$position['x']][$position['y']-1] = self::VISITED;
        $this->currentState[$newPosition['x']][$newPosition['y']] = self::VISITED;

        return $newPosition;
    }

    protected function moveDown($position)
    {
        //increment y position
        $newPosition = [];
        $newPosition['y'] = $position['y']+2;
        $newPosition['x'] = $position['x'];
        if ($position['y'] > $this->height-2 || ($this->currentState[$newPosition['y']-1] !== self::NOTOUCH && $this->currentState[$newPosition['y']] === self::VISITED)) {
            return $this->makeMove($position, ['moveDown']);
        }
        $this->currentState[$position['x']][$position['y']+1] = self::VISITED;
        $this->currentState[$newPosition['x']][$newPosition['y']] = self::VISITED;

        return $newPosition;
    }

    protected function moveLeft($position)
    {
        //decrement x position
        $newPosition = [];
        $newPosition['y'] = $position['y'];
        $newPosition['x'] = $position['x']-2;
        if ($position['x'] < 1 || ($this->currentState[$newPosition['x']+1] !== self::NOTOUCH && $newPosition['x'] === self::VISITED)) {
            return $this->makeMove($position, ['moveLeft']); //cant move left
        }
        $this->currentState[$position['x']-1][$position['y']] = self::VISITED;
        $this->currentState[$newPosition['x']][$newPosition['y']] = self::VISITED;
        return $newPosition;
    }

    protected function moveRight($position)
    {
        //increment x position
        $newPosition = [];
        $newPosition['y'] = $position['y'];
        $newPosition['x'] = $position['x']+2;
        if ($position['x'] > $this->width-2 || ($this->currentState[$newPosition['x']-1] !== self::NOTOUCH && $newPosition['x'] === self::VISITED)) {
            return $this->makeMove($position, ['moveRight']); //cant move right
        }
        $this->currentState[$position['x']+1][$position['y']] = self::VISITED;
        $this->currentState[$newPosition['x']][$newPosition['y']] = self::VISITED;

        return $newPosition;
    }

    protected function makeMove($currentPosition, $exclude = [])
    {
        $moves = ['moveUp', 'moveDown', 'moveLeft', 'moveRight'];
        if (!empty($exclude)) {
            foreach ($exclude as $invalidMove) {
                if (($key = array_search($invalidMove, $moves)) !== false) {
                    unset($moves[$key]);
                }
            }
            $moves = array_values($moves);
        }
        $move = mt_rand(0, count($moves)-1);
        $position = $this->$moves[$move]($currentPosition);
        if ($currentPosition == $position) {
            $exclude[] = $moves[$move];
            return $this->makeMove($position, $exclude);
        }
        return $position;
    }

    protected function createBoard()
    {
        $board = [];
        for ($w = 0; $w < $this->width; $w++) {
            for ($h = 0; $h < $this->height; $h++) {
                $board[$w][] = self::NOTOUCH; //all cells non-touched
            }
        }

        $this->currentState = $board;
    }

    public function getTotalCells()
    {
        return $this->width*$this->height;
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
