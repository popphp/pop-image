pop-image
=========

[![Build Status](https://github.com/popphp/pop-image/workflows/phpunit/badge.svg)](https://github.com/popphp/pop-image/actions)
[![Coverage Status](http://cc.popphp.org/coverage.php?comp=pop-image)](http://cc.popphp.org/pop-image/)

[![Join the chat at https://popphp.slack.com](https://media.popphp.org/img/slack.svg)](https://popphp.slack.com)
[![Join the chat at https://discord.gg/D9JBxPa5](https://media.popphp.org/img/discord.svg)](https://discord.gg/D9JBxPa5)

* [Overview](#overview)
* [Install](#install)
* [Quickstart](#quickstart)
    - [Load an Image](#load-an-image)
    - [Create an Image](#create-an-image)
    - [Convert an Image](#convert-an-image)
    - [Output an Image](#output-an-image)
    - [Destroy an Image](#destroy-an-image)
* [Image Adapters](#image-adapters)
    - [GD](#gd)
    - [Imagick](#imagick)
* [Advanced Editing](#advanced-editing)
* [CAPTCHA](#captcha)

Overview
--------
`pop-image` is a powerful and robust image processing component that's simple to use.
It supports the GD and Imagick extensions. The API is similar to the more
popular image editing application on the market, with calls to editing objects
that can be extended with additional image processing functionality if needed.

`pop-image` is a component of the [Pop PHP Framework](http://www.popphp.org/).

[Top](#pop-image)

Install
-------

Install `pop-image` using Composer.

    composer require popphp/pop-image

Or, require it in your composer.json file

    "require": {
        "popphp/pop-image" : "^4.0.0"
    }

[Top](#pop-image)

Quickstart
----------

#### Resizing an image

```php
use Pop\Image\Image;

$img = Image::loadGd('image.jpg');

// Resizes by using the largest dimension as the primary constraint
$img->resize(100)
    ->setQuality(50)
    ->writeToFile('image-resized.jpg');
```

```php
use Pop\Image\Image;

$img = Image::loadGd('image.jpg');

// Resizes by using width as the primary constraint
$img->resizeToWidth(100)
    ->setQuality(50)
    ->writeToFile('image-resized-width.jpg');
```

```php
use Pop\Image\Image;

$img = Image::loadGd('image.jpg');

// Scales the dimensions by the percentage
$img->scale(0.5)
    ->setQuality(50)
    ->writeToFile('image-scaled.jpg');
```

#### Crop the image

```php
use Pop\Image\Image;

$img = Image::loadGd('image.jpg');

// Crops a section of the image by width and height values
// The X and Y offsets position the crop 
$img->crop(120, 80, 100, 200) // $width, $height, $xOffset, $yOffset 
    ->setQuality(50)
    ->writeToFile('image-cropped.jpg');
```

#### Crop the image to a square thumbnail

```php
use Pop\Image\Image;

$img = Image::loadGd('image.jpg');

// The offset is automatically centered,
// unless otherwise passed as a second parameter
$img->cropThumb(100)
    ->setQuality(50)
    ->writeToFile('image-cropped-thumb.jpg');
```

[Top](#pop-image)

### Load an Image

There are a couple of ways to load an image into an image adapter:

#### Load from a file on disk:

```php
use Pop\Image\Image;

// Return an instance of the GD adapter
$gdImage = Image::loadGd('path/to/image.jpg');

// Returns an instance of the Imagick adapter
$imagickImage = Image::loadImagick('path/to/image.jpg');
```

#### Load from a stream of content:

```php
use Pop\Image\Image;

// Return an instance of the GD adapter
$gdImage = Image::loadGdFromString($imageContents, 'image.jpg');

// Returns an instance of the Imagick adapter
$imagickImage = Image::loadImagickFromString($imageContents, 'image.jpg');
```

[Top](#pop-image)

### Create an Image

There are a couple of ways to create a new image and load it into an image adapter:

#### Create an RGB-based image

```php
use Pop\Image\Image;

// Return an instance of the GD adapter
$gdImage = Image::createGd(640, 480, 'image.jpg');

// Returns an instance of the Imagick adapter
$imagickImage = Image::createImagick(640, 480, 'image.jpg');
```

#### Create an index-based image

```php
use Pop\Image\Image;

// Return an instance of the GD adapter
$gdImage = Image::createGdIndex(640, 480, 'image.jpg');

// Returns an instance of the Imagick adapter
$imagickImage = Image::createImagickIndex(640, 480, 'image.jpg');
```

[Top](#pop-image)

### Convert an Image

You can simply convert an image to another format by calling the `convert()` method:

```php
$img = Image::loadGd('image.jpg');
$img->convert('png')
    ->writeToFile('image.png');
```

**NOTE:** the GD adapter is limited to JPG, PNG and GIF formats. The Imagick adapter can work with
a large number of formats, depending on your environment. The Imagick section in the `phpinfo()`
result screen will display the list of formats available for Imagick in your environment.

[Top](#pop-image)

### Output an Image

Once you have an image adapter and have finished editing the image, you have two options
to output the image.

#### Save to disk

Use the `writeToFile()` method and pass it a filename and an optional image quality parameter:

```php
$img->writeToFile('image-cropped-thumb.jpg', 50);
```

#### Output to HTTP

Use the `outputToHttp()` method to send the image content directly an HTTP client like a browser:

```php
$img->outputToHttp();
```

This method has several optional parameters to assist with the delivery over HTTP:

```php
outputToHttp(
    ?int $quality = null,
    ?string $to = null,
    bool $download = false,
    bool $sendHeaders = true,
    array $headers = []
): void
```

- `$quality` - set the quality of the image output
- `$to` - give it a filename for a potential download
- `$download` - boolean to set the `Content-Disposition` to inline (`false`) or attachment (`true`)
- `$sendHeaders` - boolean to send the headers or just the raw payload
- `$headers` - array of additional headers to send

[Top](#pop-image)

### Destroy an Image

Destroying an image will clear the image contents from memory to assist with memory management
and prevent possibly exceeding any memory limits when working with a large number of files.

```php
$img->destroy();
```

If you wish to clear the current image file from disk, you can pass a `true` boolean to the method:

```php
$img->destroy(true);
```

[Top](#pop-image)

Image Adapters
--------------

The two image adapters available are GD and Imagick and they share a basic core API:

- `load(?string $name = null)`
- `loadFromString(string $data, ?string $name = null)`
- `create(?int $width = null, ?int $height = null, ?string $name = null)`
- `createIndex(?int $width = null, ?int $height = null, ?string $name = null)`
- `resizeToWidth(int $w)`
- `resizeToHeight(int $h)`
- `resize(int $px)`
- `scale(float $scale)`
- `crop(int $w, int $h, int $x = 0, int $y = 0)`
- `cropThumb(int $px, ?int $offset = null)`
- `rotate(int $degrees, ?Color\ColorInterface $bgColor = null, int $alpha = null)`
- `flip()`
- `flop()`

[Top](#pop-image)

### GD

To work with the GD adapter, you can load it from the main image class in a few different ways:

```php
use Pop\Image\Image;

// Return an instance of the GD adapter
$gdImage = Image::loadGd('path/to/image.jpg');

// Return an instance of the GD adapter
$gdImage = Image::loadGdFromString($imageContents, 'image.jpg');

// Return an instance of the GD adapter
$gdImage = Image::createGd(640, 480, 'image.jpg');

// Return an instance of the GD adapter
$gdImage = Image::createGdIndex(640, 480, 'image.jpg');
```

[Top](#pop-image)

### Imagick

To work with the Imagick adapter, you can load it from the main image class in a few different ways:

```php
use Pop\Image\Image;

// Returns an instance of the Imagick adapter
$imagickImage = Image::loadImagick('path/to/image.jpg');

// Returns an instance of the Imagick adapter
$imagickImage = Image::loadImagickFromString($imageContents, 'image.jpg');

// Returns an instance of the Imagick adapter
$imagickImage = Image::createImagick(640, 480, 'image.jpg');

// Returns an instance of the Imagick adapter
$imagickImage = Image::createImagickIndex(640, 480, 'image.jpg');
```

The Imagick adapter API extends the functionality with additional Imagick-specific methods:

- `addImage(mixed $image, ?int $delay = null)`
- `hasImages()`
- `getImages()`
- `rebuildImages(\Imagick $images)`
- `setResolution(int $x, ?int $y = null)`
- `setImageColorspace(int $colorspace)`
- `setCompression(int $compression)`
- `setImageFilter(int $filter)`
- `setImageBlur(float $blur)`
- `getNumberOfImages()`
- `getCompression()`
- `getImageFilter()`
- `getImageBlur()`

[Top](#pop-image)

Advanced Editing
----------------

### Using the editing objects

There are 6 available editing objects for advanced editing and adjusting of images:

* Adjust
* Draw
* Effect
* Filter
* Layer
* Type

With each of these, you can perform advanced image processing on an image. If a feature doesn't
exist yet, you can extend these classes to add your own custom features.

#### Adjust

Make image adjustments like brightness, contrast and desaturate.

#### Draw

Draw basic shapes on the image and apply strokes and fills.

#### Effect

Apply effects to the image, such as gradients.

#### Filter

Apply filters to the image, such as blur, sharpen and negate.

#### Layer

Create overlays and new layers over the image.

#### Type

Add text over the image.

##### Examples

Here are some example use cases:

```php
use Pop\Image\Image;
use Pop\Image\Color\Rgb;

$img = Image::loadImagick('image.jpg');
$img->adjust->brightness(50)
    ->contrast(50);

$img->draw->setFillColor(new Rgb(255, 0, 0))
    ->rectangle(200, 200, 100, 50);

$img->effect->verticalGradient(new Rgb(255, 0, 0), new Rgb(0, 0, 255));

$img->filter->sharpen(10)
    ->swirl(30);

$img->layer->overlay('watermark.png', 200, 200);

$img->type->font('myfont.ttf')
    ->size(24)
    ->xy(50, 100)
    ->text('Hello World!');
```

[Top](#pop-image)

CAPTCHA
-------

The `pop-image` component comes with a CAPTCHA tool to create a CAPTCHA image and store
the token value in session to validate the user's CAPTCHA input.

```php
$captcha = new Pop\Image\Captcha('/captcha.php');
header('Content-Type: image/gif');
echo $captcha;
```

The script above will generate the following image:

![CAPTCHA](tests/tmp/captcha.gif)

And with it, the `$_SESSION` variable will store a `pop_captcha` key with a serialized
value in it. When you unserialized the `$_SESSION['pop_captcha']` value, it will give you
this array:

```php  
Array
(
    [captcha] => <img id="pop-captcha-image" class="pop-captcha-image" src="/captcha.php" /><a class="pop-captcha-reload" href="#" onclick="document.getElementById('pop-captcha-image').src = '/captcha.php?captcha=1'; return false;">Reload</a>
    [answer]  => DWB6
    [expire]  => 300
    [start]   => 1574265980
)
```

You can use the `captcha` value to display the image in an HTML page and the `answer` value
to validate the user's CAPTCHA input.

[Top](#pop-image)

