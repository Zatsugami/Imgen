<?php namespace Zatsugami\Imgen\Processors;

use \Zatsugami\Imgen\ImageProcessor;
use \Intervention\Image\Image;

class Intervention extends ImageProcessor {

    /**
     * Image processor
     *
     * @var \Intervention\Image\Image
     */
    protected $imgae = null;

    public function __construct()
    {
        $this->image = new Image;
    }

    public function resizeModeNone($width, $height)
    {
        $this->image->resize($width, $height);
    }

    public function resizeModeAuto($width, $height)
    {
        $this->image->resize($width, $height, true, false);
    }

    public function resizeModeCrop($width, $height)
    {
        $this->image->resize($width, $height, true, false)->crop($width, $height);
    }

    public function resizeModeInverse($width, $height)
    {
        $this->image->resize($width, $height, true, false);
    }

    public function resizeModeWidth($width)
    {
        $this->resizeModeAuto($width, null);
    }

    public function resizeModeHeight($height)
    {
        $this->resizeModeAuto(null, $height);
    }

    public function save($path)
    {
        $info = pathinfo($path);

        if ( ! is_dir($info['dirname']) )
        {
            mkdir($info['dirname'], 0777, true);
        }

        $this->image->save($path);
    }

    public function setImage($image)
    {
        $this->image->open($image);
        return $this;
    }

}