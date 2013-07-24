<?php namespace Zatsugami\Imgen;

class Config {

    protected static $webRoot = '';

    protected $lookIn = [];
    protected $saveTo = '';
    protected $defaultMode = Imgen::AUTO;

    public function __construct($config)
    {
        $this->lookIn = (array) $config['look_in'];
        $this->saveTo = $config['save_to'];
        $this->defaultMode = isset($config['mode']) ? $config['mode'] : '';
    }

    public function getLookIn()
    {
        return $this->lookIn;
    }

    public function setLookIn($where)
    {
        $this->lookIn = (array) $where;
        return $this;
    }

    public function addLookIn($where)
    {
        if ( is_array($where) )
        {
            $this->lookIn = array_merge($this->lookIn, $where);
        }
        else
        {
            $this->lookIn[] = $where;
        }

        return $this;
    }

    public function getSaveTo()
    {
        return $this->saveTo;
    }

    public function setSaveTo($where)
    {
        $this->saveTo = $where;
        return $this;
    }

    public function getDefaultMode()
    {
        return $this->defaultMode;
    }

    public function setDefaultMode($mode)
    {
        $this->defaultMode = $mode;
        return $this;
    }

    public static function setWebRoot($webRoot)
    {
        static::$webRoot = $webRoot;
    }

    public static function getWebRoot()
    {
        return static::$webRoot;
    }

}