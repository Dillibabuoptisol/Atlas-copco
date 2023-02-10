<?php
/**
 * Upload Data Event
 *
 * Event for Upload related activities
 *
 * @name       UploadData
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UploadData
{
    use InteractsWithSockets, SerializesModels;
    public $filename, $uploadedFileId, $inputFileType;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($filename, $uploadedFileId, $inputFileName)
    {
        $this->filename = $filename;
        $this->uploadedFileId = $uploadedFileId;
        $this->inputFileName = $inputFileName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
