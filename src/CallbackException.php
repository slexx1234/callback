<?php

namespace Slexx\Callback;

class CallbackException extends \Exception
{
    /**
     * CallbackException constructor.
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct($message, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . ': [' . $this->code . ']: ' . $this->message;
    }

    /**
     * @param string $method
     * @return CallbackException
     */
    public static function methodNotStatic($method)
    {
        return new self('Метод "' . $method . '" не является статичным!', 1);
    }

    /**
     * @param string $method
     * @return CallbackException
     */
    public static function methodIsStatic($method)
    {
        return new self('Метод "' . $method . '" является статичным!', 2);
    }

    /**
     * @param string $method
     * @return CallbackException
     */
    public static function methodNotAvailable($method)
    {
        return new self('Метод "' . $method . '" не доступен!', 3);
    }

    /**
     * @param string $class
     * @return CallbackException
     */
    public static function classNotAvailable($class)
    {
        return new self('Класс "' . $class . '" не доступен!', 4);
    }

    /**
     * @param string $name
     * @return CallbackException
     */
    public static function functionNotAvailable($name)
    {
        return new self('Функция "' . $name . '" не доступен!', 5);
    }

    /**
     * @param string $method
     * @return CallbackException
     */
    public static function methodNotPublic($method)
    {
        return new self('Метод "' . $method . '" не дявляется публичным!', 6);
    }

    /**
     * @return CallbackException
     */
    public static function notCallable()
    {
        return new self('Аргумент не может быть использован в качестве функции обратного вызова!', 7);
    }

    /**
     * @return CallbackException
     */
    public static function methodIsConstructor()
    {
        return new self('В качестве функции обратного вызова не может быть использован конструктор класса!', 8);
    }
}