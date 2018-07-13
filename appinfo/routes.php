<?php
/**
 * ownCloud - recorder
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Shawn <syu702@aucklanduni.ac.nz>, Daugieras <adau828@aucklanduni.ac.nz>
 * @copyright Shawn,Daugieras 2017
 */

/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\Recorder\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */
return [
    'routes' => [
	   ['name' => 'settings#getUserValue', 'url' => '/settings', 'verb' => 'GET'],
           ['name' => 'settings#setRecorder', 'url' => '/settings', 'verb' => 'POST'],
	   ['name' => 'settings#createTxt', 'url' => '/create', 'verb' => 'POST'],
        ['name' => 'settings#getCityList', 'url' => '/getcities', 'verb' => 'GET'],
        ['name' => 'settings#getSuburbList', 'url' => '/getsuburbs/{city}', 'verb' => 'GET'],
    ]
];
