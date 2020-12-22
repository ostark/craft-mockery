<?php

namespace ostark\CraftMockery;

use ostark\CraftMockery\Concerns\DisablesYiiBehavior;
use ostark\CraftMockery\Concerns\MocksFindMethods;

class Element
{
    const TYPE = 'element';

    /**
     * @var \Mockery\Mock | mixed
     */
    protected $mock;

    protected string $className;
    protected ExpectationResolver $expectation;

    use MocksFindMethods, DisablesYiiBehavior;

    public function __construct($fqn)
    {
        $this->disableCustomFieldBehavior();

        $this->mock      = \Mockery::mock('alias:' . $fqn)->makePartial();
        $this->className = (new \ReflectionClass($fqn))->getShortName();
        $this->expectation = new ExpectationResolver(static::TYPE, $this->className);
    }

    public static function make(string $class): self
    {
        $el = new static($class);
        $el->defineFind();
        $el->defineFindAll();
        $el->defineFindOne();

        return $el;
    }

    /**
     * @return mixed|\Mockery\Mock
     */
    public function getMock()
    {
        return $this->mock;
    }

    public function getExpectation()
    {
        return $this->expectation;
    }

}