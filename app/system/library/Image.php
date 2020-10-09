<?php

class Image
{
    private $file;
    private $image;
    private $width;
    private $height;
    private $bits;
    private $mime;

    /**
     * Image constructor.
     * @param $file
     * @throws Exception
     */
    public function __construct($file)
    {
        if (!extension_loaded('gd')) {
            exit('Error: PHP GD is not installed!');
        }

        if (file_exists($file)) {
            $this->file = $file;

            $info = @getimagesize($file);
            if (!$info) {
                throw new Exception('Problem with image '.$file);
            }
            $this->width = $info[0];
            $this->height = $info[1];
            $this->bits = isset($info['bits']) ? $info['bits'] : '';
            $this->mime = isset($info['mime']) ? $info['mime'] : '';

            if ($this->mime == 'image/gif') {
                $this->image = imagecreatefromgif($file);
            } elseif ($this->mime == 'image/png') {
                $this->image = imagecreatefrompng($file);
            } elseif ($this->mime == 'image/jpeg') {
                $this->image = imagecreatefromjpeg($file);
            }
        } else {
            throw new Exception('Error: Could not load image '.$file.'!');
        }
    }

    /**
     *
     *
     * @return    string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     *
     * @return false|resource
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     *
     *
     * @return    string
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     *
     *
     * @return    string
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     *
     *
     * @return    string
     */
    public function getBits()
    {
        return $this->bits;
    }

    /**
     *
     *
     * @return    string
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     *
     *
     * @param  string  $file
     * @param  int  $quality
     */
    public function save($file, $quality = 90)
    {
        $info = pathinfo($file);

        $extension = strtolower($info['extension']);

        if (is_resource($this->image)) {
            if ($extension == 'jpeg' || $extension == 'jpg') {
                imagejpeg($this->image, $file, $quality);
            } elseif ($extension == 'png') {
                imagepng($this->image, $file);
            } elseif ($extension == 'gif') {
                imagegif($this->image, $file);
            }

            imagedestroy($this->image);
        }
    }

    /**
     *
     *
     * @param  int  $width
     * @param  int  $height
     * @param  string  $default
     */
    public function resize($width = 0, $height = 0, $default = '')
    {
        if (!$this->width || !$this->height) {
            return;
        }

        $scale_w = $width / $this->width;
        $scale_h = $height / $this->height;

        if ($default == 'w') {
            $scale = $scale_w;
        } elseif ($default == 'h') {
            $scale = $scale_h;
        } else {
            $scale = min($scale_w, $scale_h);
        }

        if ($scale == 1 && $scale_h == $scale_w && $this->mime != 'image/png') {
            return;
        }

        $new_width = (int) ($this->width * $scale);
        $new_height = (int) ($this->height * $scale);
        $xpos = (int) (($width - $new_width) / 2);
        $ypos = (int) (($height - $new_height) / 2);

        $image_old = $this->image;
        $this->image = imagecreatetruecolor($width, $height);

        if ($this->mime == 'image/png') {
            imagealphablending($this->image, false);
            imagesavealpha($this->image, true);

            $background = imagecolorallocatealpha($this->image, 255, 255, 255, 127);

            imagecolortransparent($this->image, $background);
        } else {
            $background = imagecolorallocate($this->image, 255, 255, 255);
        }

        imagefilledrectangle($this->image, 0, 0, $width, $height, $background);

        imagecopyresampled($this->image, $image_old, $xpos, $ypos, 0, 0, $new_width, $new_height, $this->width,
            $this->height);
        imagedestroy($image_old);

        $this->width = $width;
        $this->height = $height;
    }

    /**
     *
     *
     * @param  int  $top_x
     * @param  int  $top_y
     * @param  int  $bottom_x
     * @param  int  $bottom_y
     */
    public function crop($top_x, $top_y, $bottom_x, $bottom_y)
    {
        $image_old = $this->image;
        $this->image = imagecreatetruecolor($bottom_x - $top_x, $bottom_y - $top_y);

        imagecopy($this->image, $image_old, 0, 0, $top_x, $top_y, $this->width, $this->height);
        imagedestroy($image_old);

        $this->width = $bottom_x - $top_x;
        $this->height = $bottom_y - $top_y;
    }

}
