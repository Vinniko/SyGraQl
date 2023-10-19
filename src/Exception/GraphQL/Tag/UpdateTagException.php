<?php


namespace App\Exception\GraphQL\Tag;


use App\Exception\GraphQL\MutationException;
use Throwable;

class UpdateTagException extends MutationException
{
    const MESSAGE = 'ERROR_CODE_99';

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
