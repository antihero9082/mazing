<?php
namespace Test;
require '../../Class/Board.php';
use src\Board;
class BoardTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Board $board */
    protected $board;

    public function setUp()
    {
        parent::setUp();
        $this->board = new Board();
    }

    public function testGetSetWidth()
    {
        $this->board->setWidth(1337);
        $this->assertEquals(1337, $this->board->getWidth());
    }

    public function testGetSetHeight()
    {
        $this->board->setHeight(1337);
        $this->assertEquals(1337, $this->board->getHeight());
    }

    public function testGetValidCell()
    {
        $invalidHeight = $this->board->getValidCell($this->board->getHeight(), $this->board->getHeight() + 1);
        $this->assertFalse($invalidHeight);
        $invalidWidth = $this->board->getValidCell($this->board->getHeight() + 1, $this->board->getHeight());
        $this->assertFalse($invalidWidth);
        $this->assertTrue($this->board->getValidCell($this->board->getHeight(), $this->board->getHeight()));
    }

    public function testGetSetCellValue()
    {
        $xpos = $this->board->getWidth()-1;
        $ypos = $this->board->getHeight()-1;
        $this->board->setCellValue($xpos, $ypos, Board::NOTOUCH);
        $value = $this->board->getCellValue($xpos, $ypos);
        $this->assertEquals('N', $value); //not visited
    }

    public function testToArray()
    {
        $this->assertEquals([$this->board->getWidth(), $this->board->getHeight()], $this->board->toArray());
    }

    public function testGetTotalCells()
    {
        $product = $this->board->getWidth() * $this->board->getHeight();
        $this->assertEquals($product, $this->board->getTotalCells());
    }

    public function testMarkBoard()
    {
        $xPos = 1;
        $yPos = 1;
        $this->board->markBoard($xPos, $yPos);
        $this->assertEquals(Board::VISITED, $this->board->getCellValue($xPos, $yPos));
        $this->board->markBoard($xPos, $yPos);
        $this->assertEquals(Board::REVISITED, $this->board->getCellValue($xPos, $yPos));
    }
}
