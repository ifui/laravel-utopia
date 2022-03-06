<?php

namespace App\Exceptions;

use Exception;

class CodeException extends Exception
{
  public function __construct(string $code = 'code.10400')
  {
    parent::__construct($code);
  }
}
