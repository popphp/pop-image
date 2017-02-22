pop-image
=========

[![Build Status](https://travis-ci.org/popphp/pop-image.svg?branch=master)](https://travis-ci.org/popphp/pop-image)
[![Coverage Status](http://cc.popphp.org/coverage.php?comp=pop-image-imagick)](http://cc.popphp.org/pop-image/imagick/)
[![Coverage Status](http://cc.popphp.org/coverage.php?comp=pop-image-gmagick)](http://cc.popphp.org/pop-image/gmagick/)

OVERVIEW
--------
`pop-image` is a powerful and robust image processing component that's simple to use.
It supports the GD, Imagick and Gmagick extensions, as well as the SVG image format.
The API is Photoshop-like with calls to manipulation objects that can be extended
with addition image processing functionality if needed

`pop-image` is a component of the [Pop PHP Framework](http://www.popphp.org/).

INSTALL
-------

Install `pop-image` using Composer.

    composer require popphp/pop-image

BASIC USAGE
-----------

### Resizing and saving an image

```php
use Pop\Image\Image;

$img = Image::loadGd('image.jpg');
$img->resizeToHeight(100)
    ->setQuality(50)
    ->writeToFile('image-resized.jpg');

$img->cropThumb(50)
    ->save('image-thumb.jpg');
```

ADVANCED USE
------------

### Using the manipulation objects

There are 6 available manipulation objects. They are:

* Adjust
* Draw
* Effect
* Filter
* Layer
* Type

With each of these, you can perform advanced image processing manipulation on an image.
If a feature doesn't exist yet, you can extend these classes to add your own custom features.

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
