<?php

namespace Slexx\Callback;

class Callback
{
    /**
     * @var string|null
     */
    protected $class = null;

    /**
     * @var null|string
     */
    protected $type = null;

    /**
     * @var null|string|object
     */
    protected $method = null;

    /**
     * @param string|callable $callback
     * @throws CallbackException
     */
    public function __construct($callback)
    {
        if (is_string($callback)) {
            if (preg_match('/^([^:\-]+)(->|::)(.+)$/', $callback, $matches)) {
                $class = $matches[1];
                $type = $matches[2];
                $method = $matches[3];

                if (!class_exists($class)) {
                    throw CallbackException::classNotAvailable($class);
                }

                if (!method_exists($class, $method)) {
                    throw CallbackException::methodNotAvailable($method);
                }

                $reflection = new \ReflectionMethod($class, $method);

                if (!$reflection->isPublic()) {
                    throw CallbackException::methodNotPublic($method);
                }

                if ($reflection->isConstructor()) {
                    throw CallbackException::methodIsConstructor();
                }

                if ($type === '::' && !$reflection->isStatic()) {
                    throw CallbackException::methodNotStatic($method);
                } else if ($type === '->' && $reflection->isStatic()) {
                    throw CallbackException::methodIsStatic($method);
                }

                $this->class = $class;
                $this->type = $type;
                $this->method = $method;
            } else if (!function_exists($callback)) {
                throw CallbackException::functionNotAvailable($callback);
            } else {
                $this->method = $callback;
            }
        } else if (is_callable($callback)) {
            $this->class = $callback[0];
            $this->type = is_object($callback[0]) ? '->' : '::';
            $this->method = $callback[1];
        } else {
            throw CallbackException::notCallable();
        }
    }

    /**
     * @return mixed|null|string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return null|string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed|null|object|string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Вызывает функцию обратного вызова с переданными аргументами в виде массива
     * @param array [$args]
     * @return mixed
     */
    public function invokeArgs($args = [])
    {
        if ($this->class !== null) {
            if ($this->type === '::') {
                return call_user_func_array($this->class . '::' . $this->method, $args);
            } else {
                $class = is_object($this->class) ? $this->class : new $this->class;
                return call_user_func_array([$class, $this->method], $args);
            }
        } else {
            return call_user_func_array($this->method, $args);
        }
    }

    /**
     * Вызывает функцию обратного вызова
     * @param array [...$args]
     * @return mixed
     */
    public function invoke(...$args)
    {
        return $this->invokeArgs($args);
    }

    /**
     * @param array [...$arguments]
     * @return mixed
     */
    public function __invoke(...$arguments)
    {
        return $this->invokeArgs($arguments);
    }
}

