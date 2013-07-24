# Imgen - flexible, inline image manipulation utility

Imgen is a utility library, that let you create and serve images in different size variations on the fly, while being SEO friendly.

* Search for images in any path and save them anywhere
* Save images with SEO friendly file names
* Resize images on the fly

## Why Imgen and where it can help you?

Imgen is an outcome of my frustration when I was working on a project for a SEO Expert client. It was a portfolio website which served a lot of images in different size variations. You could upload an image and required size variations were created.
Everything fine so far, until I had to change size variations of every image already uploaded along with the file name... multiple times. Ouch!

If you are in a familiar situation like me, your requirements change dynamically or you just want to be *agile* when it comes to images, Imgen is here to help you out.

## Imgen is easy!
How easy?

```php
<?= image('yellow-tshirt.jpg', 'Cool Yellow T-Shirt')->crop(300, 450) ?>
```
Based on configuration may output the following:
```html
<img src="/images/products/yellow-tshirt-c300x450.jpg" alt="Cool Yellow T-Shirt" />
<!-- or -->
<img src="/images/products/300x450/yellow-tshirt.jpg" alt="Cool Yellow T-Shirt" />
<!-- or -->
<img src="/images/300/yellow-tshirt.jpg" alt="Cool Yellow T-Shirt" />
<!-- or anything else! -->
```

## Imgen is flexible!
Imgen is really flexible and let you configure important aspects of handling your images.
Let's take a look at example configuration below.

```php
# Composer autoloader
require 'vendor/autoload.php';

use \Zatsugami\Imgen\Imgen;

# Default image processor Imgen is shipped with
use \Zatsugami\Imgen\Processors\Intervention;

# You can use global instance as your delivery mechanism of Imgen object.
# You can also just invoke new Imgen(), so you can do the setup in your base controller or anywhere you want.
Imgen::instance()
# Configure image groups
->setGroups([
	# Default group MUST be defined
    'default' => [
    	# Paths are relative to webRoot config, this option does not need to be an array
        'look_in' => ['uploads/images'],
        # {~} are placeholders for processing params, you can read about them later, but they should be intuitive
        'save_to' => 'images/{m}{w}x{h}/{f}.{e}',
    ],
])
# You need to set the webRoot directory
->setWebRoot(__DIR__)
# This alows you to use any image processing library you want as long as you provide adapter class!
->setImageProcessor(new Intervention);
```

However, there is still one thing you want to do.
It's recommended that you define a global function to serve you as a helper.
```php
# It's best to setup a global helper function
if ( ! function_exists('image') )
{
    function image($filename, $alt, $group = 'default')
    {
        return Imgen::instance()->image($filename, $alt, $group);
    }
}
```
