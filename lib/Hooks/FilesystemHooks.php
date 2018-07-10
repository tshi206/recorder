<?php /** @noinspection PhpUndefinedMethodInspection */

/**
 * Created by PhpStorm.
 * User: mason
 * Date: 7/10/18
 * Time: 4:19 AM
 */

namespace OCA\Recorder\Hooks;


use OCP\Files\FileInfo;
use OCP\Files\Node;
use OCP\ILogger;

class FilesystemHooks
{

    private $logger;
    private $FilesysManager;

    public function __construct(ILogger $logger, $FilesysManager){
        $this->logger = $logger;
        $this->FilesysManager = $FilesysManager;
//        $this->log("DEBUGGING IN Recorder\FilesystemHooks : FilesysHooks initialized");
    }

    public function log($message) {
        $this->logger->emergency($message, ['app' => 'recorder']);
    }

    public function register() {

        $insertRowsInDBCallback = function (Node $node) {
            // This application ends up not using any hooks, however, I decide to leave this class as a placeholder for
            // any hook-related implementation from future developers. If you want to create customized hooking callback,
            // put your codes here. The hooks have been registered in app.php and are currently listening on file system
            // events. If you want to listen on other events, please refer to the official documentation and replace
            // corresponding parts in this file and in app.php.
            /*
            $this->log("DEBUGGING IN Recorder\FilesystemHooks : Detected INode Creation {
            file id => ".$node->getId()."
            file internal path => ".$node->getInternalPath()."
            file path => ".$node->getPath()."
            file type => ".($node->getType() === FileInfo::TYPE_FILE ? 'File' : 'Folder')."
            file type => ".$node->getSize()."
            file modified time in timestamp => ".$node->getMtime()."
            file name => ".$node->getName()."
            file mime type => ".$node->getMimetype()."
            file owner uid => ".$node->getOwner()->getUID()."
            file modified time in unix timestamp => ".$node->getMTime()."
            }");
            */
        };

        $deleteRowsInDBCallback = function(Node $node) {
            // This application ends up not using any hooks, however, I decide to leave this class as a placeholder for
            // any hook-related implementation from future developers. If you want to create customized hooking callback,
            // put your codes here. The hooks have been registered in app.php and are currently listening on file system
            // events. If you want to listen on other events, please refer to the official documentation and replace
            // corresponding parts in this file and in app.php.
            /*
            $this->log("DEBUGGING IN Recorder\FilesystemHooks : Detected INode Deletion {
            file id => ".$node->getId()."
            file internal path => ".$node->getInternalPath()."
            file path => ".$node->getPath()."
            file type => ".($node->getType() === FileInfo::TYPE_FILE ? 'File' : 'Folder')."
            file type => ".$node->getSize()."
            file modified time in timestamp => ".$node->getMtime()."
            file name => ".$node->getName()."
            file mime type => ".$node->getMimetype()."
            file owner uid => ".$node->getOwner()->getUID()."
            file modified time in unix timestamp => ".$node->getMTime()."
            }");
            */
        };

        // callback after creating files
        $this->FilesysManager->listen('\OC\Files', 'postCreate', $insertRowsInDBCallback);

        // callback after deleting files
        $this->FilesysManager->listen('\OC\Files', 'postDelete', $deleteRowsInDBCallback);

    }

}