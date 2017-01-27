<?php
namespace Htanaka0828\DbDataGenerator;

use Illuminate\Database\Capsule\Manager as Capsule;

class Generator
{
    /**
     * @var Capsule
     */
    private $capsule;

    /**
     * Generator constructor.
     * @param Capsule|null $capsule
     */
    public function __construct(Capsule $capsule = null)
    {
        $this->capsule = $capsule ?: new Capsule();
    }

    /**
     * @param array $params
     * @param string $name
     * @return $this
     */
    public function connection(array $params = [], $name = 'default')
    {
        $this->capsule->addConnection($params, $name);
        return $this;
    }
}