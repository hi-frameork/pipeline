<?php declare(strict_types=1);

namespace Hi\Pipeline;

use Hi\Pipeline\Processor\ReduceProcessor;
use Hi\Pipeline\Processor\SequenceProcessor;

class Builder
{
    /**
     * 返回 reduce 流水线示例
     *
     * @return Pipeline
     */
    public static function newReducePipeline()
    {
        $processor = new ReduceProcessor;
        $pipeline  = new Pipeline($processor);

        return $pipeline;
    }

    /**
     * 返回 Sequence 流水线实例
     *
     * @return Pipeline
     */
    public static function newSequencePipeline()
    {
        $processor = new SequenceProcessor;
        $pipeline  = new Pipeline($processor);

        return $pipeline;
    }
}

