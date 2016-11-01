<?php

namespace Mascame\ArtificerRemotemodelsPlugin;

use Mascame\Artificer\Artificer;
use Mascame\Artificer\Plugin\AbstractPlugin;

class RemoteModelsPlugin extends AbstractPlugin
{
    protected $destination_path;
    protected $remoteModels = [];

    /**
     * @var \Closure
     */
    protected $afterFetchClosure;

    public function meta()
    {
        $this->version = '1.0';
        $this->name = 'Remote Models';
        $this->description = 'Provides remote models';
        $this->author = 'Marc Mascarell';
    }

    public function boot()
    {
        $this->destination_path = $this->option->get('destination_path').DIRECTORY_SEPARATOR;
        $this->afterFetchClosure = $this->option->get('after_fetch');

        if ($fingerprint = $this->checkFingerprint()) {
            $this->setFingerprint($fingerprint);

            $this->remoteModels = $this->getRemoteModels();

            foreach ($this->remoteModels as $model) {
                $this->putModel($model);
            }
        }
    }

    /**
     * The fingerprint is used in order to avoid refetching files if it is not necessary.
     *
     * @return bool|string
     */
    public function checkFingerprint()
    {
        $url = $this->option->get('remote_fingerprint_url');

        $remote_fingerprint = \File::get($url);
        $fingerprint = \File::get($this->destination_path.'fingerprint.json');

        if ($remote_fingerprint == $fingerprint) {
            return false;
        }

        return $fingerprint;
    }

    /**
     * @param $fingerprint
     */
    protected function setFingerprint($fingerprint)
    {
        Artificer::store(
            $this->destination_path.'fingerprint.json',
            json_encode(['fingerprint' => $fingerprint])
        );
    }

    /**
     * @param $model
     */
    public function putModel($model)
    {
        $url = str_replace(':model', $model, app_path('remote_getmodel_url'));
        $file_contents = \File::get($url);

        Artificer::store($this->destination_path.$model, $this->afterFetchClosure($file_contents));
    }

    protected function getRemoteModels()
    {
        return json_decode(\File::get(app_path('remote_getmodels_url')), true);
    }
}
