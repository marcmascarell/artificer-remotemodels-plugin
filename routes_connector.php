<?php

Route::get('/remote-models', function()
{
	$remote = new \Mascame\RemoteConnector(app_path('remote_models'));

	return json_encode($remote->getModels());
});

Route::get('/remote-models/{model}', function($model)
{
	$remote = new \Mascame\RemoteConnector(app_path('remote_models'));

	if (!in_array($model, array_keys($remote->getModels()))) {
		throw new Exception('Invalid name');
	}

	return json_encode($remote->getModelFile($model));
});

Route::get('/remote-models/fingerprint', function()
{
	$remote = new \Mascame\RemoteConnector(app_path('remote_models'));

	return $remote->getFingerPrint();
});