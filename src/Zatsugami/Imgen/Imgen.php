<?php namespace Zatsugami\Imgen;

class Imgen {

    const NONE    = 'n';
    const WIDTH   = 'w';
    const HEIGHT  = 'h';
    const AUTO    = 'a';
    const FIT     = 'a';
    const INVERSE = 'i';
    const FILL    = 'i';
    const CROP    = 'c';

    protected static $instance = null;

    /**
     * Image manipulation processor
     *
     * @var ImageProcessorInterface
     */
    protected $processor = null;

    /**
     * Image groups configuration.
     *
     * Look at README for more info about configuring image groups
     *
     * @var array
     */
    protected $groups = array();

    public function setImageProcessor(ImageProcessorInterface $processor)
    {
        $this->processor = $processor;
        return $this;
    }

    public function getImageProcessor()
    {
        return $this->processor;
    }

    public function image($filename, $alt, $group = 'default')
    {
        $config = $this->groups[$group];
        return new Image($this->processor, $config, $filename, $alt);
    }

    public function setWebRoot($webRoot)
    {
        Config::setWebRoot($webRoot);
        return $this;
    }

    public static function instance()
    {
        if ( static::$instance === null )
        {
            static::$instance = new static;
        }

        return static::$instance;
    }

    public function setGroups(array $groups)
    {
        foreach ($groups as $key => $group)
        {
            $this->groups[$key] = new Config($group);
        }

        return $this;
    }
}