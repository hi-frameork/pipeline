<?php declare(strict_types=1);

namespace Hi\Pipeline;

use Hi\Pipeline\Processor\ReduceProcessor;
use Hi\Pipeline\Processor\SequenceProcessor;

class PipelineFactory
{
    /**
     * 返回 reduce 流水线示例
     *
     * @return Pipeline
     */
    public static function createReducePipeline()
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
    public static function createSequencePipeline()
    {
        $processor = new SequenceProcessor;
        $pipeline  = new Pipeline($processor);

        return $pipeline;
    }
}

