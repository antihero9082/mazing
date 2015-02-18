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

    public function testGetSetXPosition()
    {
        $this->boardPosition->setXPos(20);
        $this->assertEquals(20, $this->boardPosition->getXPos());

        $this->setExpectedException('Exception', ['Move out of bounds']);
        $this->boardPosition->setXpos(400);
    }

    public function testGetSetYPosition()
    {
        $this->boardPosition->setYPos(20);
        $this->assertEquals(20, $this->boardPosition->getYPos());

        $this->setExpectedException('Exception', ['Move out of bounds']);
        $this->boardPosition->setYPos(400);

    }

    public function testGetSetBoard()
    {
        $newBoard = new Board(40, 40);
        $this->boardPosition->setBoard($newBoard);
        $this->assertEquals($newBoard, $this->boardPosition->getBoard());
    }

    public function testMoveRight()
    {
        $move = $this->boardPosition->moveRight();
        $this->assertTrue($move);
    }

    public function testMoveRightFailsOutOfBounds()
    {
        $success = $this->boardPosition->moveRight(100); //out of bounds
        $this->assertFalse($success);
    }

    public function testMoveRightFailsOutOfBoundsRevisited()
    {
        $destination = 5;

        $this->boardPosition->moveRight(5);
    }

    public function testMoveLeft()
    {
        $this->boardPosition->setXpos(10); //move to a spot that can move to the left, instead of default of 1
        $moveSuccess = $this->boardPosition->moveLeft(1);
        $this->assertTrue($moveSuccess);
    }

    public function testMoveLeftFailsOutOfBounds()
    {
        $moveSuccess = $this->boardPosition->moveLeft(1); //at start position, cant move left
        $this->assertFalse($moveSuccess);
    }

    public function testMoveup()
    {
        $this->boardPosition->setYpos(10); //move to a spot that can move up, instead of default of 1
        $moveSuccess = $this->boardPosition->moveUp(1);
        $this->assertTrue($moveSuccess);
    }

    public function testMoveUpFailsOutOfBounds()
    {
        $moveSuccess = $this->boardPosition->moveUp(1);
        $this->assertFalse($moveSuccess);
    }

    public function testMoveDown()
    {
        $moveSuccess = $this->boardPosition->moveDown(1);
        $this->assertTrue($moveSuccess);
    }

    public function testMoveDownFailsOutOfBounds()
    {
        $moveSuccess = $this->boardPosition->moveDown(100); //larger than Y axis
        $this->assertFalse($moveSuccess);
    }
}
