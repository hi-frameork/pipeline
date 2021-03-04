<?php declare(strict_types=1);

namespace Hi\Pipeline;

use Hi\Pipeline\Processor\ProcessorInterface;

use function is_callable;
use function array_unshift;
use function array_push;

/**
 * 管道 - 管道模式，可自定义管道处理器
 */
class Pipeline implements PipelineInterface
{
    /**
     * @var ProcessorInterface
     */
    protected $processor;

    /**
     * @var array
     */
    protected $stages = [];

    /**
     * @var string
     */
    protected $method;

    /**
     * @param ProcessorInterface $processor
     * @param array $stages
     */
    public function __construct(
        ProcessorInterface $processor,
        $method = 'handle'
    ) {
        $this->processor = $processor;

        if ($method) {
            $this->method = $method;
        }
    }

    /**
     * 管道节点初始化
     *
     * @param string|object $stage
     * @return object
     */
    private function filterStage($stage)
    {
        if (! is_callable($stage)) {
            throw new Exception('$stage type must be object or string');
        }

        return $stage;
    }

    /**
     * {@inheritDoc}
     */
    public function prependStage($stage)
    {
        array_unshift($this->stages, $this->filterStage($stage));
    }

    /**
     * {@inheritDoc}
     */
    public function appendStage($stage)
    {
        array_push($this->stages, $this->filterStage($stage));
    }

    /**
     * 返回管道节点执行时被调用的行方法
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * {@inheritDoc}
     */
    public function process($payload = null, $finalCallback = null)
    {
        // 设置管道节点被调用方法
        $this->processor->setMethod($this->method);

        // 管道处理开始
        return $this->processor->process($this->stages, $payload, $finalCallback);
    }
}
