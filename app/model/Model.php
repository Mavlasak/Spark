<?php

namespace App\Model;

use Nette;
use Nette\Caching\Cache;
use App\Model\PostgreDriver;

//use Tracy\Debugger;

class Model {

    private $PostgreDriver;
    private $cache;

    public function __construct(PostgreDriver $PostgreDriver) {
        $this->PostgreDriver = $PostgreDriver;
        $this->cache = new Cache(new Nette\Caching\Storages\FileStorage(__DIR__ . '..\..\..\data'));
    }

    private function saveIntoCache($id, $value) {
        $this->cache->save($id, $value);
    }

    public function getProduct($id) {
        $value = $this->cache->load($id);
        if ($value === null) {
            $value = $this->PostgreDriver->getProductById($id);
        }
        if ($value['dotazy'] === null) {
            $value['dotazy'] = 1;
        } else {
            $value['dotazy'] = ++$value['dotazy'];
        }
        $this->saveIntoCache($id, $value);
        return $value;
    }

}
