<?php declare(strict_types=1);

namespace Hi\Pipeline\Processor;

use Closure;

/**
 * reduce 处理器
 * 以 reduce 方式将管道节点转换为链式回调
 */
class ReduceProcessor implements ProcessorInterface
{
    /**
     * @var string
     */
    protected $method;

    /**
     * {@inheritDoc}
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * {@inheritDoc}
     */
    public function process($stages, $payload, $finalStackCallback = null)
    {
        $this->finalStackCallback = $finalStackCallback;

        // 将管道节点转换为 reduce 链式回调
        // 下一个管道节点执行与否控制权交给正在执行的管道节点
        // 以此将业务处理控制流转交至业务处理方手中
        $stack = $this->reduce(
            $stages,
            $this->finalStackCallback($finalStackCallback)
        );

        return call_user_func($stack, $payload);
    }

    /**
     * 将管道节点进行 reduce 
     *
     * @param array $stages
     * @return Closure
     */
    private function reduce($stages, $finalStackCallback)
    {
        return array_reduce(
            array_reverse($stages),
            $this->createStackCallback(),
            $finalStackCallback
        );
    }

    /**
     * 创建 reduce 链式回调
     * 实现管道节点扁平化转换
     *
     * @return Closure
     */
    private function createStackCallback()
    {
        return function ($stack, $stage) {
            return function ($payload) use ($stack, $stage) {
                // 每个管道节点执行前触发处理器回调事件
                // 我们可以在该回调中进行日志金路、耗时统计等
                if (! is_null($this->beforeCallback)) {
                    call_user_func($this->beforeCallback, $stage, $payload);
                }

                // 拼接下一个管道节点将接收的参数
                // 节点执行方法绑定
                // 触发管道节点调用
                $params = [$payload, $stack];
                $handle = [$stage, $this->method];
                $result = call_user_func_array($handle, $params);

                // 每个管道节点执行前触发处理器回调事件
                // 我们可以在该回调中进行日志金路、耗时统计等
                if (! is_null($this->afterCallback)) {
                    call_user_func($this->afterCallback, $stage, $payload);
                }

                return $result;
            };
        };
    }

    /**
     * 返回所有管道节点迭代完回调事件
     *
     * @return Closure
     */
    protected function finalStackCallback($callback)
    {
        if (is_null($callback)) {
            return function ($payload) {
                return $payload;
            };
        }

        return $callback;
    }
}

