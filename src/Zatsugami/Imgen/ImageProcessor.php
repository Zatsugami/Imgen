<?php namespace Zatsugami\Imgen;

abstract class ImageProcessor implements ImageProcessorInterface {

    public function resize($width, $height, $mode)
    {
        switch ($mode)
        {
            case 'n': $this->resizeModeNone($width, $height);    break;
            case 'a': $this->resizeModeAuto($width, $height);    break;
            case 'c': $this->resizeModeCrop($width, $height);    break;
            case 'i': $this->resizeModeInverse($width, $height); break;
            case 'w': $this->resizeModeWidth($width);            break;
            case 'h': $this->resizeModeHeight($height);          break;
        }

        return $this;
    }

    public abstract function save($savepath);
    public abstract function setImage($image);

    public abstract function resizeModeNone($width, $height);
    public abstract function resizeModeAuto($width, $height);
    public abstract function resizeModeCrop($width, $height);
    public abstract function resizeModeInverse($width, $height);
    public abstract function resizeModeWidth($width);
    public abstract function resizeModeHeight($height);

}