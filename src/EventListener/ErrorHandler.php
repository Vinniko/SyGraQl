<?php


namespace App\EventListener;

use GraphQL\Error\Error;
use GraphQL\Error\FormattedError;
use Overblog\GraphQLBundle\Event\ExecutorResultEvent;

class ErrorHandler
{
    public function onPostExecutor(ExecutorResultEvent $event)
    {
        $errorFormatter = function(Error $error) {
            return [
                "message" => $error->getMessage(),
            ];
        };

        $errorHandler = function(array $errors, callable $formatter) {
            return array_map($formatter, $errors);
        };

        $event->getResult()
            ->setErrorFormatter($errorFormatter)
            ->setErrorsHandler($errorHandler);
    }
}
