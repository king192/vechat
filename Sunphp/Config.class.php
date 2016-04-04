<?php
namespace Sunphp;

class Config implements \ArrayAccess
{
    protected $path;
    protected $configs = array();

    function __construct($path)
    {
        // echo '1';
        $this->path = $path;
    }

    function offsetGet($key)
    {
            // echo 'heiheiheiheiheihei';
        if (empty($this->configs[$key]))
        {
            $file_path = $this->path.'/'.$key.'.php';
            $config = require $file_path;
            $this->configs[$key] = $config;
        }
        return $this->configs[$key];
    }

    function offsetSet($key, $value)
    {
        // echo '2';
        throw new \Exception("cannot write config file.");
    }

    function offsetExists($key)
    {
        // echo '3';
        return isset($this->configs[$key]);
    }

    function offsetUnset($key)
    {
        // echo '4';
        unset($this->configs[$key]);
    }
}