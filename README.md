pop-image
=========

[![Build Status](https://github.com/popphp/pop-image/workflows/phpunit/badge.svg)](https://github.com/popphp/pop-image/actions)
[![Coverage Status](http://cc.popphp.org/coverage.php?comp=pop-image)](http://cc.popphp.org/pop-image/)

[![Join the chat at https://discord.gg/TZjgT74U7E](https://media.popphp.org/img/discord.svg)](https://discord.gg/TZjgT74U7E)

* [Overview](#overview)
* [Requirements](#requirements)
* [Install](#install)
* [Quickstart](#quickstart)
    - [Load an Image](#load-an-image)
    - [Create an Image](#create-an-image)
    - [Convert an Image](#convert-an-image)
    - [Image Information](#image-information)
    - [Output an Image](#output-an-image)
    - [Destroy an Image](#destroy-an-image)
* [Image Adapters](#image-adapters)
    - [Checking Available Adapters](#checking-available-adapters)
    - [GD](#gd)
    - [Imagick](#imagick)
* [Working with Color](#working-with-color)
* [Advanced Editing](#advanced-editing)
    - [Adjust](#adjust)
    - [Draw](#draw)
    - [Effect](#effect)
    - [Filter](#filter)
    - [Layer](#layer)
    - [Type](#type)
* [Error Handling](#error-handling)

Overview
--------
`pop-image` is a powerful and robust image processing component that's simple to use.
It supports the GD and Imagick extensions. The API is similar to the more
popular image editing application on the market, with calls to editing objects
that can be extended with additional image processing functionality if needed.

`pop-image` is a component of the [Pop PHP Framework](https://www.popphp.org/).

[Top](#pop-image)

Requirements
------------

- PHP >= 8.4.0
- The `gd` extension — required
- The `imagick` extension — optional; needed to use the Imagick adapter, and required for image
  formats beyond JPG, PNG and GIF (which is all the GD adapter supports)

[Top](#pop-image)

Install
-------

Install `pop-image` using Composer.

    composer require popphp/pop-image

Or, require it in your composer.json file

    "require": {
        "popphp/pop-image" : "^5.0.0"
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

#### Rotate, flip and flop an image

```php
use Pop\Image\Image;

$img = Image::loadGd('image.jpg');

// Rotates the image 90 degrees clockwise
$img->rotate(90)
    ->writeToFile('image-rotated.jpg');
```

```php
use Pop\Image\Image;

$img = Image::loadGd('image.jpg');

// Flips the image vertically, over the x-axis
$img->flip()
    ->writeToFile('image-flipped.jpg');
```

```php
use Pop\Image\Image;

$img = Image::loadGd('image.jpg');

// Flops the image horizontally, over the y-axis
$img->flop()
    ->writeToFile('image-flopped.jpg');
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

An index-based (palette) image is used for formats like GIF, where the image is limited to a
palette of colors rather than full truecolor:

```php
use Pop\Image\Image;

// Return an instance of the GD adapter
$gdImage = Image::createGdIndex(640, 480, 'image.gif');

// Returns an instance of the Imagick adapter
$imagickImage = Image::createImagickIndex(640, 480, 'image.gif');
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

### Image Information

Once an image has been loaded or created, you can inspect its properties:

```php
$img->getName();        // string - the image's file name
$img->getWidth();       // int    - the image's width, in pixels
$img->getHeight();      // int    - the image's height, in pixels
$img->getFormat();      // string - the image's format, e.g. 'jpg', 'png', 'gif'
$img->getQuality();     // int    - the currently-set output quality (0-100)
$img->getColorspace();  // int    - one of Adapter\AbstractAdapter::IMAGE_GRAY|IMAGE_RGB|IMAGE_CMYK
$img->isGray();         // bool
$img->isRgb();          // bool
$img->isCmyk();         // bool
$img->isIndexed();      // bool   - true for palette-based images (GIF, or images made with createIndex())
$img->getExif();        // array  - EXIF data, automatically read from JPEG images on load
```

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
- `rotate(int $degrees, ?Color\ColorInterface $bgColor = null)` — the GD adapter additionally accepts
  a trailing `?int $alpha = null` argument for the fill color's alpha channel (0-127)
- `flip()`
- `flop()`

[Top](#pop-image)

### Checking Available Adapters

Not every environment has both the `gd` and `imagick` extensions installed. You can check which
adapters are available before deciding which one to use:

```php
use Pop\Image\Image;

$adapters = Image::getAvailableAdapters(); // ['gd' => true, 'imagick' => false]

if (Image::isAvailable('imagick')) {
    $img = Image::loadImagick('image.jpg');
} else {
    $img = Image::loadGd('image.jpg');
}
```

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

Working with Color
-------------------

Color values passed into the API (fills, strokes, backgrounds, gradients, etc.) come from the
companion [`popphp/pop-color`](https://github.com/popphp/pop-color) package's `Pop\Color\Color`
namespace, not from raw GD or Imagick color values:

```php
use Pop\Color\Color\Rgb;
use Pop\Color\Color\Hex;
use Pop\Color\Color\Cmyk;
use Pop\Color\Color\Grayscale;
use Pop\Color\Color\Hsl;

$red  = new Rgb(255, 0, 0);
$blue = new Hex('#0000FF');
$cyan = new Cmyk(100, 0, 0, 0);
$gray = new Grayscale(50);
$teal = new Hsl(180, 100, 25);
```

Any of these `ColorInterface` implementations can be passed anywhere the API calls for a color —
both adapters normalize non-RGB colors to RGB internally as needed.

[Top](#pop-image)

Advanced Editing
----------------

### Using the editing objects

There are 6 available editing objects for advanced editing and adjusting of images, each
accessible as a property on the image adapter: `$img->adjust`, `$img->draw`, `$img->effect`,
`$img->filter`, `$img->layer` and `$img->type`.

* **Adjust** - Make image adjustments like brightness, contrast and desaturate.
* **Draw** - Draw basic shapes on the image and apply strokes and fills.
* **Effect** - Apply effects to the image, such as gradients.
* **Filter** - Apply filters to the image, such as blur, sharpen and negate.
* **Layer** - Create overlays and new layers over the image.
* **Type** - Add text over the image.

```php
use Pop\Image\Image;
use Pop\Color\Color\Rgb;

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

Each editing object's full method set is broken out below. Not every method exists on both
backends — Imagick generally exposes more of ImageMagick's native functionality than GD can
support.

[Top](#pop-image)

### Adjust

Make tonal adjustments to the image.

| Method | GD | Imagick |
|---|:---:|:---:|
| `brightness(int $amount)` | ✓ | ✓ |
| `contrast(int $amount)` | ✓ | ✓ |
| `desaturate()` | ✓ | ✓ |
| `hue(int $amount)` | | ✓ |
| `saturation(int $amount)` | | ✓ |
| `hsb(int $h, int $s, int $b)` | | ✓ |
| `level(int $black, float $gamma, int $white)` | | ✓ |

```php
$img->adjust->brightness(20)
    ->contrast(10)
    ->desaturate();
```

[Top](#pop-image)

### Draw

Draw shapes on the image and apply fills and strokes.

Shared setters (both adapters):

- `setOpacity(int|float $opacity)`
- `setFillColor(Color\ColorInterface $color)`
- `setStrokeColor(Color\ColorInterface $color)`
- `setStrokeWidth(int $w)`

Shapes:

| Method | GD | Imagick |
|---|:---:|:---:|
| `line($x1, $y1, $x2, $y2)` | ✓ | ✓ |
| `rectangle($x, $y, $w, $h = null)` | ✓ | ✓ |
| `square($x, $y, $w)` | ✓ | ✓ |
| `roundedRectangle($x, $y, $w, $h = null, $rx = 10, $ry = null)` | | ✓ |
| `roundedSquare($x, $y, $w, $rx = 10, $ry = null)` | | ✓ |
| `ellipse($x, $y, $w, $h = null)` | ✓ | ✓ |
| `circle($x, $y, $w)` | ✓ | ✓ |
| `arc($x, $y, $start, $end, $w, $h = null)` | ✓ | ✓ |
| `chord($x, $y, $start, $end, $w, $h = null)` | ✓ | ✓ |
| `pie($x, $y, $start, $end, $w, $h = null)` | ✓ | ✓ |
| `polygon(array $points)` | ✓ | ✓ |

`$h` defaults to `$w` when omitted, drawing a regular (equal-sided) shape. `polygon()` takes a flat
array of coordinates: `[$x1, $y1, $x2, $y2, ...]`. GD's shape methods accept `int|float` for all
coordinate/size arguments; Imagick's are `int`-only.

```php
$img->draw->setFillColor(new Rgb(255, 0, 0))
    ->setStrokeColor(new Rgb(0, 0, 0))
    ->setStrokeWidth(2)
    ->rectangle(200, 200, 100, 50);
```

[Top](#pop-image)

### Effect

Apply borders, fills and gradients.

- `border(Color\ColorInterface $color, $w, $h = null)`
- `fill(Color\ColorInterface $color)`
- `radialGradient(Color\ColorInterface $color1, Color\ColorInterface $color2)`
- `verticalGradient(Color\ColorInterface $color1, Color\ColorInterface $color2)`
- `horizontalGradient(Color\ColorInterface $color1, Color\ColorInterface $color2)`
- `linearGradient(Color\ColorInterface $color1, Color\ColorInterface $color2, bool $vertical = true)`

`linearGradient()` is a convenience wrapper around `verticalGradient()`/`horizontalGradient()`,
chosen by the `$vertical` flag.

```php
$img->effect->fill(new Rgb(255, 255, 255));
$img->effect->border(new Rgb(0, 0, 0), 2);
$img->effect->verticalGradient(new Rgb(255, 0, 0), new Rgb(0, 0, 255));
```

[Top](#pop-image)

### Filter

Apply image filters. This is where GD and Imagick diverge the most — GD wraps a handful of the
built-in `imagefilter()` filters, while Imagick exposes a much larger part of ImageMagick's native
filter/effect API:

| GD | Imagick |
|---|---|
| `blur(int $amount, int $type = IMG_FILTER_GAUSSIAN_BLUR)` | `blur($radius = 0, $sigma = 0, $channel = Imagick::CHANNEL_ALL)` |
| | `adaptiveBlur($radius = 0, $sigma = 0, $channel = Imagick::CHANNEL_DEFAULT)` |
| | `gaussianBlur($radius = 0, $sigma = 0, $channel = Imagick::CHANNEL_ALL)` |
| | `motionBlur($radius = 0, $sigma = 0, $angle = 0, $channel = Imagick::CHANNEL_DEFAULT)` |
| `sharpen(int $amount)` | `sharpen($radius = 0, $sigma = 0, $channel = Imagick::CHANNEL_ALL)` |
| `negate()` | `negate()` |
| `colorize(Color\Rgb $color)` | |
| `pixelate(int $px)` | `pixelate(int $w, ?int $h = null)` |
| `pencil()` | `pencil($radius, $sigma, $angle)` |
| | `paint(int $radius)` |
| | `posterize(int $levels, bool $dither = false)` |
| | `noise($type = Imagick::NOISE_MULTIPLICATIVEGAUSSIAN, $channel = Imagick::CHANNEL_DEFAULT)` |
| | `diffuse(int $radius)` |
| | `skew(int $x, int $y, ?Color\ColorInterface $color = null)` |
| | `swirl(int $degrees)` |
| | `wave($amp, $length)` |

```php
$img->filter->sharpen(10);
$img->filter->pixelate(8);
```

[Top](#pop-image)

### Layer

Overlay other images on top of the current image, and, with Imagick, manage layers and frames.

- `overlay(string $image, int $x = 0, int $y = 0)` — both adapters
- `getOverlay(): int` / `setOverlay(int $overlay)` — Imagick only; the Imagick composite constant
  (e.g. `Imagick::COMPOSITE_OVER`) used internally by `overlay()`
- `flatten(int $method = Imagick::LAYERMETHOD_FLATTEN)` — Imagick only; collapses a multi-layer or
  multi-frame image down to a single image

```php
$img->layer->overlay('watermark.png', 200, 200);
```

[Top](#pop-image)

### Type

Add text to the image.

- `font(string $font)` — path to a TrueType font file (GD falls back to a built-in bitmap font if
  no font is set)
- `size(int $size)`
- `x(int $x)` / `y(int $y)` / `xy(int $x, int $y)`
- `rotate(int $degrees)`
- `setFillColor(Color\ColorInterface $color)`
- `setStrokeColor(Color\ColorInterface $color)`
- `setStrokeWidth(int $w)`
- `setOpacity(int|float $opacity)`
- `text(string $string)` — renders the string using the settings above

```php
$img->type->font('myfont.ttf')
    ->size(24)
    ->setFillColor(new Rgb(0, 0, 0))
    ->xy(50, 100)
    ->text('Hello World!');
```

[Top](#pop-image)

Error Handling
--------------

Each namespace has its own exception class rather than one shared exception type:

- `Pop\Image\Adapter\Exception`
- `Pop\Image\Adjust\Exception`
- `Pop\Image\Draw\Exception`
- `Pop\Image\Effect\Exception`
- `Pop\Image\Filter\Exception`
- `Pop\Image\Layer\Exception`
- `Pop\Image\Type\Exception`

These are thrown for image-specific error conditions, such as loading a file that doesn't exist,
converting to an unsupported format, or writing to disk before an image has been created or loaded.

A couple of range-checked parameters throw PHP's built-in `\OutOfRangeException` instead:

- The quality parameter (`setQuality()`, `writeToFile()`, `outputToHttp()`) must be between 0 and 100.
- The GD adapter's alpha parameter (`rotate()`, `createColor()`) must be between 0 and 127.

```php
use Pop\Image\Image;

try {
    $img = Image::loadGd('image.jpg')
        ->writeToFile('image.jpg', 150); // quality out of range
} catch (\Pop\Image\Adapter\Exception $e) {
    // handle an adapter-level error
} catch (\OutOfRangeException $e) {
    // handle an out-of-range quality/alpha value
}
```

[Top](#pop-image)
