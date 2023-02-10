<?php
/**
 * Send Mail Event
 *
 * Event for Send mail related activities
 *
 * @name       Parts Planning
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

class SendMail
{
    use InteractsWithSockets, SerializesModels;
    public $emailId, $emailContent, $subject;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($emailId, $emailContent, $subject)
    {
        $this->emailId = $emailId;
        $this->emailContent = $emailContent;
        $this->subject = $subject;
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
