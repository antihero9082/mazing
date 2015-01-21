<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 1/20/15
 * Time: 4:37 PM
 */

namespace src\Exception;


class IllegalMoveException extends \Exception
{
    public function __construct()
    {
        $this->message = 'Move not allowed.';
    }
}
