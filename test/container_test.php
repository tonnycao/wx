<?php
require 'bootstrap.php';
use Xcrms\Wx\Container;

$container = new Container();

class Bim
{
    public function doSomething()
    {
        echo __METHOD__, '|';
    }
}

class Bar
{
    private $bim;

    public function __construct(Bim $bim)
    {
        $this->bim = $bim;
    }

    public function doSomething()
    {
        $this->bim->doSomething();
        echo __METHOD__, '|';
    }
}

class Foo
{
    private $bar;

    public function __construct(Bar $bar)
    {
        $this->bar = $bar;
    }

    public function doSomething($str)
    {
        $this->bar->doSomething();
        echo __METHOD__;
        echo $str.PHP_EOL;
    }
}


$container->foo = function ($container){
    echo 'this is foo';
};


 $ff = $container->foo;
 $ff();
echo "\n\n\n";


echo "整个处理结束\n";
//$foo->doSomething('sssss'); // Bim::doSomething|Bar::doSomething|Foo::doSomething
echo "\n\n";