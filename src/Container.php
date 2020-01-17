<?php


namespace Xcrms\Wx;


use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{

    protected $binds;

    protected $instances;

    private $s = array();


    public function __set($k, $c)
    {
        $this->s[$k] = $c;
    }

    public function __get($k)
    {
        // return $this->s[$k]($this);
        return $this->build($this->s[$k]);
    }

    public function getS () {
        return $this->s;
    }


    public function has($id){

    }

    public function get($id){

    }

    public function build($className, $flag = false)
    {
        echo "\n\n";
        echo "--------------------处理{$className}--------------------------------------------------------------------------\n";
        if ($flag) {
            echo "递归解析{$className}\n";
        } else {
            echo "非递归解析{$className}\n";
        }

        // 如果是匿名函数（Anonymous functions），也叫闭包函数（closures）
        echo "显示是否是instanceof Closure\n";

        if ($className instanceof Closure) {
            // 执行闭包函数，并将结果
            return $className($this);
        }

        /** @var ReflectionClass $reflector */
        $reflector = new \ReflectionClass($className);
        echo "显示ReflectionClass\n";
        var_dump($reflector);

        // 检查类是否可实例化, 排除抽象类abstract和对象接口interface
        echo "检查类是否可实例化, 排除抽象类abstract和对象接口interface\n";

        if (!$reflector->isInstantiable()) {
            throw new \Exception("Can't instantiate this.");
        }

        /** @var ReflectionMethod $constructor 获取类的构造函数 */
        $constructor = $reflector->getConstructor();
        echo "获取类的构造函数\n";
        var_dump($constructor);

        // 若无构造函数，直接实例化并返回
        if (is_null($constructor)) {

            $o = new $className;

            return $o;
        }

        // 取构造函数参数,通过 ReflectionParameter 数组返回参数列表
        $parameters = $constructor->getParameters();
        echo "取构造函数参数,通过 ReflectionParameter 数组返回参数列表\n";
        var_dump($parameters);

        // 递归解析构造函数的参数
        echo "<<<<开始>>>>递归解析构造函数的参数\n";
        $dependencies = $this->getDependencies($parameters);
        echo "递归结束\n";
        var_dump($dependencies);

        // 创建一个类的新实例，给出的参数将传递到类的构造函数。
        echo "创建一个类的新实例，给出的参数将传递到类的构造函数\n";
        $b = $reflector->newInstanceArgs($dependencies);
        var_dump($b);
        return $b;
    }

    public function getDependencies($parameters)
    {
        echo "--------在方法getDependencies中--------\n";
        echo "显示参数\n";
        var_dump($parameters);
        $dependencies = [];

        /** @var ReflectionParameter $parameter */
        echo "进入循环\n";
        foreach ($parameters as $parameter) {
            var_dump($parameter);
            /** @var ReflectionClass $dependency */
            $dependency = $parameter->getClass();
            var_dump($dependency);
            var_dump(is_null($dependency));
            if (is_null($dependency)) {
                // 是变量,有默认值则设置默认值
                echo "是变量,有默认值则设置默认值\n";
                $dependencies[] = $this->resolveNonClass($parameter);
            } else {
                // 是一个类，递归解析
                echo "是一个类，递归解析\n";
                $dependencies[] = $this->build($dependency->name, true);
            }
        }
        echo "方法getDependencies结束\n";
        echo "返回值\n";
        var_dump($dependencies);

        return $dependencies;
    }
    public function resolveNonClass($parameter)
    {
        // 有默认值则返回默认值
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        throw new \Exception('I have no idea what to do here.');
    }

}