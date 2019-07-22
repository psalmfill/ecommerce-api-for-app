<?php
namespace Api;
use Illuminate\Support\Str;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Manager;
use League\Fractal\Serializer\DataArraySerializer;

class BaseRepository {

    public $manager;
    

    public function __construct(Manager $manager, DataArraySerializer $dataArraySerializer)
    {
        $this->manager = new $manager;
        $manager->setSerializer(new $dataArraySerializer);
    }
    public function generateUuid() {
        
        return Str::uuid()->toString();
    }

    public function transformItem($item, $transformer)
    {
        return $this->createSerilizer(new Item($item,$transformer));
    }

    public function transformCollection($collection, $transformer)
    {   
        return $this->createSerilizer(new Collection($collection, $transformer)) ;
    }
    private function createSerilizer($resource)
    {
        return $this->manager->createData($resource)->toArray();
    }
}