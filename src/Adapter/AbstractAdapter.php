<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp-framework
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2024 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Image\Adapter;

use Pop\Image\Adjust;
use Pop\Color\Color;
use Pop\Image\Draw;
use Pop\Image\Effect;
use Pop\Image\Filter;
use Pop\Image\Layer;
use Pop\Image\Type;

/**
 * Abstract adapter class
 *
 * @category   Pop
 * @package    Pop\Image
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2024 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    4.0.0
 */
abstract class AbstractAdapter implements AdapterInterface
{

    /**
     * Colorspace constants
     */
    const IMAGE_GRAY = 1;
    const IMAGE_RGB  = 2;
    const IMAGE_CMYK = 3;

    /**
     * Image resource
     * @var mixed
     */
    protected mixed $resource = null;

    /**
     * Image name
     * @var string
     */
    protected string $name = 'pop-image.jpg';

    /**
     * Image width
     * @var int
     */
    protected int $width = 640;

    /**
     * Image height
     * @var int
     */
    protected int $height = 480;

    /**
     * Image format
     * @var string
     */
    protected string $format = 'jpg';

    /**
     * Image quality
     * @var int
     */
    protected int $quality = 100;

    /**
     * Image colorspace
     * @var int
     */
    protected int $colorspace = 2;

    /**
     * Index color flag
     * @var bool
     */
    protected bool $indexed = false;

    /**
     * EXIF data
     * @var array
     */
    protected array $exif = [];

    /**
     * Image adjust object
     * @var ?Adjust\AdjustInterface
     */
    protected ?Adjust\AdjustInterface $adjust = null;

    /**
     * Image draw object
     * @var ?Draw\DrawInterface
     */
    protected ?Draw\DrawInterface $draw = null;

    /**
     * Image effect object
     * @var ?Effect\EffectInterface
     */
    protected ?Effect\EffectInterface $effect = null;

    /**
     * Image filter object
     * @var ?Filter\FilterInterface
     */
    protected ?Filter\FilterInterface $filter = null;

    /**
     * Image layer object
     * @var ?Layer\LayerInterface
     */
    protected ?Layer\LayerInterface $layer = null;

    /**
     * Image type object
     * @var ?Type\TypeInterface
     */
    protected ?Type\TypeInterface $type = null;

    /**
     * Constructor
     *
     * Instantiate an image object based on either a pre-existing image
     * file on disk, or a new image file.
     *
     */
    public function __construct()
    {
        $args = func_get_args();

        $this->createResource();

        // $image
        if (isset($args[0]) && !is_numeric($args[0]) && file_exists($args[0])) {
            $this->name = $args[0];
            $this->load();
        // $width, $height, $name
        } else if ((count($args) >= 2) && is_numeric($args[0]) && is_numeric($args[1])) {
            $this->width  = $args[0];
            $this->height = $args[1];
            if (isset($args[2]) && !is_numeric($args[2])) {
                $this->name = $args[2];
            }
            $this->create();
        }
    }

    /**
     * Create the image resource
     *
     * @return void
     */
    abstract public function createResource(): void;

    /**
     * Get the image resource
     *
     * @return mixed
     */
    public function getResource(): mixed
    {
        return $this->resource;
    }

    /**
     * Determine if there is an image resource
     *
     * @return bool
     */
    public function hasResource(): bool
    {
        return ($this->resource !== null);
    }

    /**
     * Get the image name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the image width
     *
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * Get the image height
     *
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * Get the image quality
     *
     * @return int
     */
    public function getQuality(): int
    {
        return $this->quality;
    }

    /**
     * Get the colorspace
     *
     * @return int
     */
    public function getColorspace(): int
    {
        return $this->colorspace;
    }

    /**
     * Determine if the image is index color
     *
     * @return bool
     */
    public function isIndexed(): bool
    {
        return $this->indexed;
    }

    /**
     * Get the image format
     *
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * Get the image EXIF data
     *
     * @return array
     */
    public function getExif(): array
    {
        return $this->exif;
    }

    /**
     * Determine if the image is grayscale
     *
     * @return bool
     */
    public function isGray(): bool
    {
        return ($this->colorspace == self::IMAGE_GRAY);
    }

    /**
     * Determine if the image is RGB
     *
     * @return bool
     */
    public function isRgb(): bool
    {
        return ($this->colorspace == self::IMAGE_RGB);
    }

    /**
     * Determine if the image is CMYK
     *
     * @return bool
     */
    public function isCmyk(): bool
    {
        return ($this->colorspace == self::IMAGE_CMYK);
    }

    /**
     * Set the image quality
     *
     * @oaram  int $quality
     * @return static
     */
    public function setQuality(int $quality): static
    {
        $this->quality = $quality;
        return $this;
    }

    /**
     * Send image headers the image
     *
     * @param  ?string $to
     * @param  bool    $download
     * @param  array   $additionalHeaders
     * @return void
     */
    public function sendHeaders(?string $to = null, bool $download = false, array $additionalHeaders = []): void
    {
        if ($to === null) {
            $to = ($this->name !== null) ? basename($this->name) : 'pop-image.' . $this->format;
        }

        // Determine if the force download argument has been passed.
        $headers = [
            'Content-type'        => 'image/' . (($this->format == 'jpg') ? 'jpeg' : $this->format),
            'Content-disposition' => (($download) ? 'attachment; ' : null) . 'filename=' . $to
        ];

        if (!empty($additionalHeaders)) {
            $headers = $headers + $additionalHeaders;
        }

        // Send the headers and output the image
        if (!headers_sent()) {
            header('HTTP/1.1 200 OK');
            foreach ($headers as $name => $value) {
                header($name . ': ' . $value);
            }
        }
    }

    /**
     * Magic get method to return a manipulation object
     *
     * @param  string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'adjust' => $this->adjust(),
            'filter' => $this->filter(),
            'layer'  => $this->layer(),
            'draw'   => $this->draw(),
            'effect' => $this->effect(),
            'type'   => $this->type(),
            default  => null,
        };
    }

    /**
     * Load the image resource from the existing image file
     *
     * @param  ?string $name
     * @return AbstractAdapter
     */
    abstract public function load(?string $name = null): AbstractAdapter;

    /**
     * Load the image resource from data
     *
     * @param  string  $data
     * @param  ?string $name
     * @return AbstractAdapter
     */
    abstract public function loadFromString(string $data, ?string $name = null): AbstractAdapter;

    /**
     * Create a new image resource
     *
     * @param  ?int    $width
     * @param  ?int    $height
     * @param  ?string $name
     * @return AbstractAdapter
     */
    abstract public function create(?int $width = null, ?int $height = null, ?string $name = null): AbstractAdapter;

    /**
     * Create a new indexed image resource
     *
     * @param  ?int    $width
     * @param  ?int    $height
     * @param  ?string $name
     * @return AbstractAdapter
     */
    abstract public function createIndex(?int $width = null, ?int $height = null, ?string $name = null): AbstractAdapter;

    /**
     * Resize the image object to the width parameter passed
     *
     * @param  int $w
     * @return AbstractAdapter
     */
    abstract public function resizeToWidth(int $w): AbstractAdapter;

    /**
     * Resize the image object to the height parameter passed
     *
     * @param  int $h
     * @return AbstractAdapter
     */
    abstract public function resizeToHeight(int $h): AbstractAdapter;

    /**
     * Resize the image object, allowing for the largest dimension
     * to be scaled to the value of the $px argument.
     *
     * @param  int $px
     * @return AbstractAdapter
     */
    abstract public function resize(int $px): AbstractAdapter;

    /**
     * Scale the image object, allowing for the dimensions to be scaled
     * proportionally to the value of the $scl argument.
     *
     * @param  float $scale
     * @return AbstractAdapter
     */
    abstract public function scale(float $scale): AbstractAdapter;

    /**
     * Crop the image object to a image whose dimensions are based on the
     * value of the $wid and $hgt argument. The optional $x and $y arguments
     * allow for the adjustment of the crop to select a certain area of the
     * image to be cropped.
     *
     * @param  int $w
     * @param  int $h
     * @param  int $x
     * @param  int $y
     * @return AbstractAdapter
     */
    abstract public function crop(int $w, int $h, int $x = 0, int $y = 0): AbstractAdapter;

    /**
     * Crop the image object to a square image whose dimensions are based on the
     * value of the $px argument. The optional $offset argument allows for the
     * adjustment of the crop to select a certain area of the image to be cropped.
     *
     * @param  int  $px
     * @param  ?int $offset
     * @return AbstractAdapter
     */
    abstract public function cropThumb(int $px, ?int $offset = null): AbstractAdapter;

    /**
     * Rotate the image object
     *
     * @param  int                   $degrees
     * @param  ?Color\ColorInterface $bgColor
     * @throws Exception
     * @return AbstractAdapter
     */
    abstract public function rotate(int $degrees, ?Color\ColorInterface $bgColor = null): AbstractAdapter;

    /**
     * Method to flip the image over the x-axis
     *
     * @return AbstractAdapter
     */
    abstract public function flip(): AbstractAdapter;

    /**
     * Method to flip the image over the y-axis
     *
     * @return AbstractAdapter
     */
    abstract public function flop(): AbstractAdapter;

    /**
     * Get the image adjust object
     *
     * @return Adjust\AdjustInterface
     */
    abstract public function adjust(): Adjust\AdjustInterface;

    /**
     * Get the image filter object
     *
     * @return Filter\FilterInterface
     */
    abstract public function filter(): Filter\FilterInterface;

    /**
     * Get the image layer object
     *
     * @return Layer\LayerInterface
     */
    abstract public function layer(): Layer\LayerInterface;

    /**
     * Get the image draw object
     *
     * @return Draw\DrawInterface
     */
    abstract public function draw(): Draw\DrawInterface;

    /**
     * Get the image effect object
     *
     * @return Effect\EffectInterface
     */
    abstract public function effect(): Effect\EffectInterface;

    /**
     * Get the image type object
     *
     * @return Type\TypeInterface
     */
    abstract public function type(): Type\TypeInterface;

    /**
     * Convert the image object to another format
     *
     * @param  string $type
     * @throws Exception
     * @return AbstractAdapter
     */
    abstract public function convert(string $type): AbstractAdapter;

    /**
     * Write the image object to a file on disk
     *
     * @param  ?string $to
     * @param  int     $quality
     * @throws Exception
     * @return void
     */
    abstract public function writeToFile(?string $to = null, int $quality = 100): void;

    /**
     * Output the image object directly to HTTP
     *
     * @param  int     $quality
     * @param  ?string $to
     * @param  bool    $download
     * @param  bool    $sendHeaders
     * @throws Exception
     * @return void
     */
    abstract public function outputToHttp(int $quality = 100, ?string $to = null, bool $download = false, bool $sendHeaders = true): void;

    /**
     * Destroy the image object and the related image file directly
     *
     * @param  bool $delete
     * @return void
     */
    abstract public function destroy(bool $delete = false): void;

    /**
     * Create and return a color.
     *
     * @param  ?Color\ColorInterface $color
     * @param  int                   $alpha
     * @throws Exception
     * @return mixed
     */
    abstract public function createColor(?Color\ColorInterface $color = null, int $alpha = 100): mixed;

    /**
     * Output the image
     *
     * @return string
     */
    abstract public function __toString(): string;

}