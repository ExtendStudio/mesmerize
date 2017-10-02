<?php


namespace Mesmerize;


class Color
{
    private $r;
    private $g;
    private $b;
    private $a;

    public function __construct($value = "#000000")
    {
        list($this->r, $this->g, $this->b, $this->a) = \Kirki_Color::get_rgba($value);
    }

    public function getBrightness()
    {
        $brightness = ($this->r * 299 + $this->g * 587 + $this->b * 114) / 1000;

        return $brightness;
    }

    public function isDark()
    {
        return ($this->getBrightness() < 128);
    }

    public function isLight()
    {
        return ! $this->isLight();
    }

    public function getHex()
    {
        return "#" . \Kirki_Color::sanitize_color($this->getRGBA(), 'hex');
    }

    public function getRGBA()
    {
        return sprinf('rgba(%1$s, %2$s, %3$s, %4$s)', $this->r, $this->g, $this->b, $this->a);
    }

    public function getRGB()
    {
        return sprinf('rgb(%1$s, %2$s, %3$s)', $this->r, $this->g, $this->b);
    }


    public function adjustBrightness($steps)
    {
        $value   = $this->getHex();
        $this->r = max(0, min(255, hexdec(substr($value, 0, 2)) + $steps));
        $this->g = max(0, min(255, hexdec(substr($value, 2, 2)) + $steps));
        $this->b = max(0, min(255, hexdec(substr($value, 4, 2)) + $steps));

    }
}