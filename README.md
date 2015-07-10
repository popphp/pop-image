Pop Image
=========
Part of the Pop PHP Framework (http://github.com/popphp/popphp)

[![Build Status](https://travis-ci.org/popphp/pop-image.svg?branch=master)](https://travis-ci.org/popphp/pop-image)

OVERVIEW
--------
Pop Image is a component of the Pop PHP Framework 2. It is a powerful and robust image processing
component that's simple to use. It supports the GD, Imagick and Gmagick extensions, as well as
the SVG image format. The API is Photoshop-like with calls to manipulation objects that can be
extended with addition image processing functionality if needed

INSTALL
-------

Install `Pop Image` using Composer.

    composer require popphp/pop-image

BASIC USAGE
-----------

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
There are 6 available manipulation objects. They are:

* Adjust*
* Draw
* Effect
* Filter*
* Layer*
* Type

(* - Not available for SVG)

Which each of these, you can perform advanced image processing manipulation on an image.
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
