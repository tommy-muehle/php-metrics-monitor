<?php

namespace MetricsMonitor\Service\Parser;

use MetricsMonitor\Model\Data;

/**
 * @package MetricsMonitor\Service\Parser
 */
interface ParserInterface
{
    /**
     * @param \SplFileInfo $file
     *
     * @return Data
     */
    public function parse(\SplFileInfo $file);

    /**
     * @param \SplFileInfo $file
     * 
     * @return bool
     */
    public function supports(\SplFileInfo $file);
}
