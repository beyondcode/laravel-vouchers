<?php

namespace BeyondCode\Vouchers;

use Illuminate\Support\Str;

class VoucherGenerator
{
    protected $characters;
    protected $mask;
    protected $prefix;
    protected $suffix;
    protected $separator = '-';
    protected $generatedCodes = [];

    public function __construct(string $characters = 'ABCDEFGHJKLMNOPQRSTUVWXYZ234567890', string $mask = '****-****')
    {
        $this->characters = $characters;
        $this->mask = $mask;
    }

    /**
     * @param string $prefix
     */
    public function setPrefix(?string $prefix): void
    {
        $this->prefix = $prefix;
    }

    /**
     * @param string $suffix
     */
    public function setSuffix(?string $suffix): void
    {
        $this->suffix = $suffix;
    }

    /**
     * @param string $separator
     */
    public function setSeparator(string $separator): void
    {
        $this->separator = $separator;
    }

    /**
     * @return string
     */
    public function generateUnique(): string
    {
        $code = $this->generate();

        while (in_array($code, $this->generatedCodes) === true) {
            $code = $this->generate();
        }

        $this->generatedCodes[] = $code;
        return $code;
    }

    /**
     * @return string
     */
    public function generate(): string
    {
        $length = substr_count($this->mask, '*');

        $code = $this->getPrefix();
        $mask = $this->mask;
        $characters = collect(str_split($this->characters));

        for ($i = 0; $i < $length; $i++) {
            $mask = Str::replaceFirst('*', $characters->random(1)->first(), $mask);
        }

        $code .= $mask;
        $code .= $this->getSuffix();

        return $code;
    }

    /**
     * @return string
     */
    protected function getPrefix(): string
    {
        return $this->prefix !== null ? $this->prefix . $this->separator : '';
    }

    /**
     * @return string
     */
    protected function getSuffix(): string
    {
        return $this->suffix !== null ? $this->separator . $this->suffix : '';
    }

}
