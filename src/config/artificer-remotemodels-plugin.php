<?php

return array(
	/*
	 * This route should return RemoteConnector getModels() method
	 */
	'remote_getmodels_url' => 'http://domain.com/remote-models',

	/*
	 * This route should return RemoteConnector getModelFile(:model) method
	 */
	'remote_getmodel_url' => 'http://domain.com/remote-model/:model',

	/*
	 * This route should return RemoteConnector getFingerPrint() method
	 */
	'remote_fingerprint_url' => 'http://domain.com/remote-models/fingerprint',

	/*
	 * Destination where models will be copied
	 */
	'destination_path' => app_path('models'),

	/*
	 * Do any kind of postprocess after fetch the file contents (for example removing namespace)
	 */
	'after_fetch' => function($content) {
		return $content;
	}
);