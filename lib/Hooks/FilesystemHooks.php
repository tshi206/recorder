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
            // TODO : your code that executes after $node is created
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
        };

        $deleteRowsInDBCallback = function(Node $node) {
            // TODO : your code that executes after $node is deleted
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
        };

        // callback after creating files
        $this->FilesysManager->listen('\OC\Files', 'postCreate', $insertRowsInDBCallback);

        // callback after deleting files
        $this->FilesysManager->listen('\OC\Files', 'postDelete', $deleteRowsInDBCallback);

    }

}