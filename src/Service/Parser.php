<?php

namespace MetricsMonitor\Service;

use FooBar\Exception\ParserException;
use MetricsMonitor\Exception\UnsupportedException;
use MetricsMonitor\Model\Data;
use MetricsMonitor\Service\Parser\ParserInterface;

/**
 * @package MetricsMonitor\Service
 */
class Parser
{
    /**
     * @var array
     */
    private $parsers = [];

    /**
     * @param ParserInterface $parser
     */
    public function add(ParserInterface $parser)
    {
        $this->parsers[] = $parser;
    }

    /**
     * @param \SplFileInfo $file
     *
     * @return bool
     */
    public function supports(\SplFileInfo $file)
    {
        if (false === file_exists($file->getRealPath())) {
            return false;
        }

        if ($this->getSupportedParser($file) instanceof ParserInterface) {
            return true;
        }

        return false;
    }

    /**
     * @param \SplFileInfo $file
     *
     * @return Data
     * @throws UnsupportedException
     */
    public function parse(\SplFileInfo $file)
    {
        $parser = $this->getSupportedParser($file);

        if (!$parser instanceof ParserInterface) {
            throw UnsupportedException::create($file);
        }

        return $parser->parse($file);
    }

    /**
     * @param \SplFileInfo $file
     *
     * @return ParserInterface|null
     */
    private function getSupportedParser(\SplFileInfo $file)
    {
        foreach ($this->parsers as $parser) {
            if (true === $parser->supports($file)) {
                return $parser;
            }
        }

        return null;
    }
}
