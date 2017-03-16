<?php

namespace SergeyMiracle\Config;

use Illuminate\Config\Repository as RepositoryBase;

class Repository extends RepositoryBase
{
    /**
     * The config rewriter object.
     *
     * @var string
     */
    protected $writer;

    /**
     * Create a new configuration repository.
     *
     * @param  array $items
     * @param  FileWriter $writer
     */
    public function __construct($items = array(), $writer)
    {
        $this->writer = $writer;
        parent::__construct($items);
    }

    /**
     * Write a given configuration value to file.
     *
     * @param array $values
     * @return void
     * @throws \Exception
     * @internal param string $key
     * @internal param mixed $value
     */
    public function write(array $values)
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value);
            [$filename, $item] = $this->parseKey($key);
            $config[$filename][$item] = $value;
        }

        foreach ($config as $filename => $items) {
            $path = config_path($filename . '.php');

            if (!is_writeable($path)) {
                throw new \Exception('Configuration file ' . $filename . '.php is not writable.');
            }

            if (!$this->rewrite->toFile($path, $items)) {
                throw new \Exception('Unable to update configuration file ' . $filename . '.php');
            }
        }
    }

    /**
     * Split key into 2 parts. The first part will be the filename
     * @param $key
     * @return array
     */
    private function parseKey($key)
    {
        return preg_split('/\./', $key, 2);
    }
}