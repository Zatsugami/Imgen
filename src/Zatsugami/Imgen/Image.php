<?php namespace Zatsugami\Imgen;

class Image {

    /**
     * Image config object
     *
     * @var Config
     */
    protected $config;

    /**
     * Image processor
     *
     * @var ImageProcessorInterface
     */
    protected $processor;

    protected $filename = '';
    protected $alt = '';
    protected $attrs = [];

    protected $compiledFilePath = '';

    protected $urlOnly = false;
    protected $width = null;
    protected $height = null;
    protected $mode = null;

    public function __construct(ImageProcessorInterface $processor, Config $config, $filename, $alt)
    {
        $this->processor = $processor;
        $this->config = $config;

        $this->filename = $filename;
        $this->alt = $alt;
    }

    public function url()
    {
        $this->urlOnly = true;
    }

    public function width($width)
    {
        return $this->size($width, null)->mode(Imgen::WIDTH);
    }

    public function height($height)
    {
        return $this->size(null, $height)->mode(Imgen::HEIGHT);
    }

    public function size($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
        return $this;
    }

    public function fill($width, $height)
    {
        return $this->size($width, $height)->mode(Imgen::FILL);
    }

    public function fit($width, $height)
    {
        return $this->size($width, $height)->mode(Imgen::FIT);
    }

    public function crop($width, $height)
    {
        return $this->size($width, $height)->mode(Imgen::CROP);
    }

    public function mode($mode)
    {
        $this->mode = $mode;
        return $this;
    }

    public function attrs(array $attrs)
    {
        $this->attrs = $attrs;
    }

    protected function save()
    {
        $savePath = $this->getSavePath();

        if ( ! file_exists($savePath) )
        {
            $this->processor
                ->setImage($this->findFile())
                ->resize($this->width, $this->height, $this->mode)
                ->save($savePath);
        }

        return $this;
    }

    public function findFile()
    {
        foreach ($this->config->getLookIn() as $path)
        {
            if ( file_exists($path.DIRECTORY_SEPARATOR.$this->filename) )
            {
                return $path.DIRECTORY_SEPARATOR.$this->filename;
            }
        }

        return $this;
    }

    public function getSavePath()
    {
        $webRoot = $this->config->getWebRoot();
        $path = $this->config->getSaveTo();
        $filenameInfo = pathinfo($this->filename);

        # Apply processing params to the path
        $path = strtr($path, array(
            '{w}' => $this->width,
            '{h}' => $this->height,
            '{f}' => $filenameInfo['filename'],
            '{e}' => $filenameInfo['extension'],
            '{m}' => $this->getMode(),
        ));

        $this->compiledFilePath = $path;

        return $webRoot.DIRECTORY_SEPARATOR.$path;
    }

    public function getMode()
    {
        return is_null($this->mode) ? $this->config->getDefaultMode() : $this->mode;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }

    protected function getUrl()
    {
        return $this->compiledFilePath;
    }

    protected function getTag()
    {
        return '<img src="'.$this->compiledFilePath
            .'" alt="'.$this->alt.'"'
            .$this->htmlAttributes($this->attrs).' />';
    }

    protected function htmlAttributes($attributes)
    {
        if ( empty($attributes) ) return '';

        $compiled = '';
        foreach ($attributes as $key => $value)
        {
            if ($value === NULL)
            {
                // Skip attributes that have NULL values
                continue;
            }

            // Add the attribute key
            $compiled .= ' '.$key;
            // Add the attribute value
            $compiled .= '="'.$this->htmlChars($value).'"';
        }

        return $compiled;
    }

    protected function htmlChars($value)
    {
        return htmlspecialchars( (string) $value, ENT_QUOTES, 'UTF-8');
    }

    public function __toString()
    {
        $this->save();
        return $this->urlOnly ? $this->getUrl() : $this->getTag();
    }

}