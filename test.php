<?php

# Coposer autoloader
require 'vendor/autoload.php';

use \Zatsugami\Imgen\Imgen;

# Default processor that Imgen is shipped with
use \Zatsugami\Imgen\Processors\Intervention;

# You can use global instance as your delivery mechanism of Imgen object.
# You can also create object, so you can do the setup in your base controller or whatever you want.
Imgen::instance()->setGroups([
    'default' => [
        'look_in' => ['uploads/images'], # Paths are relative to webRoot config, does not need to be an array
        'save_to' => 'images/{m}{w}x{h}/{f}.{e}', # {~} are placeholders for processing params
    ],
])->setWebRoot(__DIR__)
->setImageProcessor(new Intervention);

# You can use any image processor library you like. You just need to write a proxy class and pass it to the Imgen.
# In this example we are using Intervention/Image bundle.

# It's best to setup a global helper function
if ( ! function_exists('image') )
{
    function image($filename, $alt, $group = 'default')
    {
        return Imgen::instance()->image($filename, $alt, $group);
    }
}

echo image('obrazek.jpg', 'Ale obrazek')->crop(400, 300).PHP_EOL;