<?php
namespace Api\Handler;

use Phalcon\Mvc\Controller as PhController;
use League\{
    Fractal\Resource\Collection,
    Fractal\Resource\Item
};

/**
 * Abstract Api controller.
 *
 * @category  Core
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2014-2015
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 */
abstract class AbstractController extends PhController
{
    /**
     * Initializes the controller.
     *
     * @return void
     */
    public function initialize()
    {
        $di = $this->getDI();
    }

    public function onConstruct()
    {
        $this->fractal = $this->getDI()->get('fractal');
    }

    public function respondWithArray($array, $key)
    {
        $response = [$key => $array];

        return $this->onResponse($response);
    }

    public function respondWithOK()
    {
        $response = ['result' => 'OK'];

        return $this->onResponse($response);
    }

    public function createItemWithOK($item, $callback, $resource_key)
    {
        $response = $this->createItem($item, $callback, $resource_key);
        $response['result'] = 'OK';

        return $this->onResponse($response);
    }

    public function createItem($item, $callback, $resource_key, $meta = [])
    {
        $resource = new Item($item, $callback, $resource_key);
        $data = $this->fractal->createData($resource)->toArray();
        $response = array_merge($data, $meta);

        return $this->onResponse($response);
    }

    public function createCollection($collection, $callback, $resource_key, $meta = [])
    {
        $resource = new Collection($collection, $callback, $resource_key);
        $data = $this->fractal->createData($resource)->toArray();
        $response = array_merge($data, $meta);

        return $this->onResponse($response);
    }

    public function onResponse($response)
    {
        return $this->response->send($response);
    }

    /**
     * get Current URL
     */
    public function getCurrentUrl()
    {
        return $this->router->getRewriteUri();
    }

    /**
     * get specified key from json POST
     */
    public function getParam($key = '')
    {
        $formData = (array) json_decode($this->request->getRawBody());

        if (strlen($key) > 0 && array_key_exists($key, $formData)) {
            return $formData[$key];
        } else {
            return $formData;
        }
    }
}
