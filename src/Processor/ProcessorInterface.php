<?php

namespace Hi\Pipeline\Processor;

/**
 * 管道处理器接口
 */
interface ProcessorInterface
{
    /**
     * 设置管道节点被调用方法
     *
     * @param string $method
     */
    public function setMethod($mthod);

    /**
     * 开始迭代执行管道节点
     *
     * @param array $stages
     * @param mixed $payload
     * @param callback $finalStackCallback
     * @return mixed
     */
    public function process($stages, $payload, $finalStackCallback = null);
}

