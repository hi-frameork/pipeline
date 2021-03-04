<?php declare(strict_types=1);

namespace Hi\Pipeline\Processor;

/**
 * 循序化迭代与性管道节点
 */
class SequenceProcessor implements ProcessorInterface
{
    /**
     * @var sgring
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
        foreach ($stages as $stage) {
            $handle  = [$stage, $this->method];
            $payload = call_user_func($handle, $payload);
        }

        return $payload;
    }
}
