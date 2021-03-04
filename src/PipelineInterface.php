<?php

namespace Hi\Pipeline;

interface PipelineInterface
{
    /**
     * 将流水线处理节点前置到流水线中
     *
     * @param MiddlewareInterface $stage
     */
    public function prependStage($stage);

    /**
     * 将流水线处理节点追加到流水线中
     *
     * @param MiddlewareInterface $stage
     */
    public function appendStage($stage);

    /**
     * 开始管道业务处理
     *
     * @param mixed $payload
     * @param Closure|callback $finalCallback
     * @return mixed
     */
    public function process($payload = null, $finalCallback = null);
}
