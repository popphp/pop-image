pop-image
=========
Part of the Pop PHP Framework (http://github.com/popphp/popphp)

[![Build Status](https://travis-ci.org/popphp/pop-image.svg?branch=master)](https://travis-ci.org/popphp/pop-image)
[![Coverage Status](http://www.popphp.org/cc/coverage.php?comp=pop-image)](http://www.popphp.org/cc/pop-image/)

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
$img = new Pop\Image\Gd('image.jpg');
$img->resizeToHeight(100)
    ->setQuality(50)
    ->save('image-resized.jpg');

$img->cropThumb(50)
    ->save('image-thumb.jpg');
```

ADVANCED USE
------------

### Using the manipulation objects

There are 6 available manipulation objects. They are:

* Adjust*
* Draw
* Effect
* Filter*
* Layer*
* Type

(* - Not available for SVG)

With each of these, you can perform advanced image processing manipulation on an image.
If a feature doesn't exist yet, you can extend these classes to add your own custom features.

```php
$img = new Pop\Image\Imagick('image.jpg');
$img->adjust->brightness(50)
            ->contrast(50);

$img->draw->setFillColor(255, 0, 0)
          ->rectangle(200, 200, 100, 50);

$img->effect->verticalGradient([255, 0, 0], [0, 0, 255]);

$img->filter->sharpen(10)
            ->swirl(30);

$img->layer->overlay('watermark.png', 200, 200);

$img->type->font('myfont.ttf')
          ->size(24)
          ->xy(50, 100)
          ->text('Hello World!');
```

### Working with SVG images

The SVG image object has a similar API but is a bit different, given that it's a vector
image. Here's an example of creating an SVG with a rectangle filled with a gradient:

```php
$image = new Pop\Image\Svg('image.svg', '640', '480');
$image->addLinearGradient([255, 0, 0], [0, 0, 255]);
$image->draw->rectangle(0, 0, 640, 480);
$image->output();
```

This would output to the browser:

```xml
<?xml version="1.0" standalone="no"?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<svg xmlns="http://www.w3.org/2000/svg" width="640" height="480" version="1.1">
  <desc>
        SVG Image generated by Pop PHP Framework
    </desc>
  <rect x="0" y="0" width="640" height="480" fill="rgb(255,0,0)"/>
  <defs>
    <linearGradient id="grad0" x1="0%" y1="0%" x2="0%" y2="100%">
      <stop offset="0%" style="stop-color: rgb(255,0,0); stop-opacity: 1;"/>
      <stop offset="100%" style="stop-color: rgb(0,0,255); stop-opacity: 1;"/>
    </linearGradient>
  </defs>
</svg>
```
