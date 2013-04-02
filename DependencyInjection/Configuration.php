<?php

namespace Funstaff\TikaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration
 *
 * @author Bertrand Zuchuat <bertrand.zuchuat@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    private $debug;

    /**
     * Constructor
     *
     * @param Boolean $debug Whether to use the debug mode
     */
    public function  __construct($debug)
    {
        $this->debug = (Boolean) $debug;
    }

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('funstaff_tika');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('tika_path')->isRequired()->end()
                ->scalarNode('output_format')->defaultValue('xml')
                    ->validate()
                        ->ifNotInArray(array('xml', 'html', 'text'))
                        ->thenInvalid('Not authorized value for output (only xml, html and text)')
                    ->end()
                ->end()
                ->scalarNode('output_encoding')->defaultValue('UTF-8')->end()
                ->booleanNode('logging')->defaultValue($this->debug)->end()
            ->end();

        return $treeBuilder;
    }
}
