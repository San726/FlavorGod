<?php namespace Flavorgod\Models\Repository;

use FitlifeGroup\Models\Eloquent\Channel;
use Exception;

trait DistinguishesChannel
{
    protected $channel;

    protected function throwIfNoChannel()
    {
        if (isset($this->channel) && $this->channel instanceof Channel) {
            return;
        }

        throw new Exception('No channel selected.');
    }

    public function setChannel($channel)
    {
        if ($channel instanceof Channel) {
            $this->channel = $channel;
        } elseif (is_numeric($channel)) {
            $this->channel = Channel::find($channel);
        }

        return $this;
    }

    public function getChannel()
    {
        return $this->channel;
    }
}