<?php

namespace Sven\ArtisanView\Tests;

use League\Flysystem\Filesystem;
use Sven\ArtisanView\ViewFactory;
use League\Flysystem\Adapter\Local;
use GrahamCampbell\TestBench\AbstractPackageTestCase;

abstract class TestCase extends AbstractPackageTestCase
{
    /**
     * @var  \League\Flysystem\Filesystem
     */
    protected $filesystem;

    /**
     * @var  \Sven\ArtisanView\ViewFactory
     */
    protected $view;

    /**
     * Set up the testing suite.
     *
     * @return  null
     */
    public function setUp()
    {
        $adapter = new Local(__DIR__.'\\assets');

        $this->filesystem = new Filesystem($adapter);
        $this->view = new ViewFactory($this->filesystem);
    }

    /**
     * Tear down the application suite.
     *
     * @return  null
     */
    public function tearDown()
    {
        $directory = realpath(__DIR__.'\\assets');
        $iterator = new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($files as $file) {
            $file->isDir() ? rmdir($file->getRealPath()) : unlink($file->getRealPath());
        }
    }
}
