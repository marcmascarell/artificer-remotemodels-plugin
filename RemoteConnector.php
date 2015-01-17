<?php namespace Mascame;


class RemoteConnector {

    protected $path;
    protected $models = array();

    /**
     * @param $path
     */
    public function __construct($path) {
        $this->path = $path;
        $this->models = $this->getModels($path);

    }

    /**
     * @param null $path
     * @return array
     */
    public function getModels($path = null) {
        if ($this->models != null) return $this->models;

        $models = array();

        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));

        $iterator->rewind();
        while($iterator->valid()) {

            if (!$iterator->isDot()) {
                $models[$iterator->getFilename()] = $iterator->getRealPath();
            }

            $iterator->next();
        }

        return $models;
    }

    /**
     * @param $model
     * @return string
     */
    public function getModelFile($model) {
        return file_get_contents($this->models[$model]);
    }

    /**
     * @return string
     */
    public function getFingerPrint() {
        $fingerprint = 0;

        foreach ($this->models as $model) {
            $fingerprint += filemtime($model);
        }

        return md5($fingerprint);
    }
}