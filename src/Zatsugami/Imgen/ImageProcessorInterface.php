<?php namespace Zatsugami\Imgen;

interface ImageProcessorInterface {

    public function resize($width, $height, $mode);
    public function save($savepath);
    public function setImage($image);

}