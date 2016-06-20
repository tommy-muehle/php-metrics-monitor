<?php

namespace MetricsMonitor\Service;

use MetricsMonitor\Exception\UnsupportedException;

/**
 * @package MetricsMonitor\Service
 */
class Broker
{
    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var Storage
     */
    private $storage;

    /**
     * @param Parser  $parser
     * @param Storage $storage
     */
    public function __construct(Parser $parser, Storage $storage)
    {
        $this->parser = $parser;
        $this->storage = $storage;
    }

    /**
     * @param \SplFileInfo $file
     * @param string $slug
     *
     * @throws UnsupportedException
     */
    public function execute(\SplFileInfo $file, $slug = null)
    {
        if (false === $this->parser->supports($file)) {
            throw UnsupportedException::create($file);
        }

        $data = $this->parser->parse($file);
        $data->setSlug($slug);

        $this->storage->persist($data->getType(), $data);
    }
}
