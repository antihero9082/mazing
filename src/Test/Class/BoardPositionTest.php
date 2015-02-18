<?php
namespace Test;

require '../../Class/BoardPosition.php';
require_once '../../Class/Board.php';
use src\Board;
use src\BoardPosition;
class BoardPositionTest extends \PHPUnit_Framework_TestCase
{
    /** @var  BoardPosition */
    protected $boardPosition;

    public function setUp()
    {
        parent::setUp();
        $this->boardPosition = new BoardPosition(new Board());
    }

    public function testGetSetBoard()
    {
        $newBoard = new Board(40, 40);
        $this->boardPosition->setBoard($newBoard);
        $this->assertEquals($newBoard, $this->boardPosition->getBoard());
    }

    public function testMoveRight()
    {
       $this->boardPosition->moveRight();
    }
}