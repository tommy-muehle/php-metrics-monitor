<?php

namespace MetricsMonitor\Service\Parser;

use MetricsMonitor\Exception\ParserException;
use MetricsMonitor\Model\Data;

/**
 * @package MetricsMonitor\Service\Parser
 */
class CoverageParser implements ParserInterface
{
    /**
     * @param \SplFileInfo $file
     *
     * @return bool
     */
    public function supports(\SplFileInfo $file)
    {
        $document = new \DOMDocument();
        $document->load($file->getRealPath());

        return @$document->schemaValidate(__DIR__ . '/../../Resources/PHPUnit/coverage.xsd');
    }

    /**
     * @param \SplFileInfo $file
     *
     * @return Data
     */
    public function parse(\SplFileInfo $file)
    {
        $xml = @simplexml_load_file($file->getRealPath());

        return new Data('coverage', $this->getDate($xml), $this->getScore($xml));
    }

    /**
     * @param \SimpleXMLElement $element
     *
     * @return \DateTime
     */
    private function getDate(\SimpleXMLElement $element)
    {
        $coverage = current($element->xpath('//coverage/@generated'));

        $date = new \DateTime;
        $date->setTimestamp((string) $coverage['generated']);

        return $date;
    }

    /**
     * @param \SimpleXMLElement $element
     *
     * @return float
     * @throws ParserException
     */
    private function getScore(\SimpleXMLElement $element)
    {
        $metrics = current($element->xpath('//project/metrics'));

        if (false === $metrics) {
            throw ParserException::create('Cannot get score!');
        }

        $elements = $metrics->attributes();

        return round((float) $elements['ncloc'] / (float) $elements['loc'] * 100, 2);
    }
}
