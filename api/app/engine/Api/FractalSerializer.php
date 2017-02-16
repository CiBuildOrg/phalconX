<?php
namespace Engine\Api;

use League\Fractal\Serializer\ArraySerializer;

/**
 * Custom fractal array serializer.
 *
 * @category  ThePhalconPHP
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2014-2015
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 */
class FractalSerializer extends ArraySerializer
{
    public function collection($resourceKey, array $data)
    {
        if ($resourceKey == 'parent') {
            return $data;
        }

        return array($resourceKey ?: 'data' => $data);
    }

    public function item($resourceKey, array $data)
    {
        if ($resourceKey == 'parent') {
            return $data;
        }
        return array($resourceKey ?: 'data' => $data);
    }
}
