<?php namespace Flavorgod\Services;

//use FitlifeGroup\Models\Eloquent\Channel;
use Exception;
use Carbon\Carbon;
use Flavorgod\Models\Eloquent\Channel;
use FitlifeGroup\Models\Eloquent\Agent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class ChannelAttribution
{
    protected $custom;
    protected $channel;
    protected $agent;
    protected $referer;

    public function getCustom()
    {
        return $this->custom;
    }

    public function getChannel()
    {
        return $this->channel;
    }

    public function getChannelId()
    {
        return isset($this->channel) ? $this->channel->id : 0;
    }

    public function getAgent()
    {
        return $this->agent;
    }

    public function getAgentId()
    {
        return isset($this->agent) ? $this->agent->id : 0;
    }

    public function setReferer($referer)
    {
        // Store this value
        $this->referer = strtolower($referer);

        // Regular Expression for breaking down the URL
        $re = '/^(((http|https):)?\\/\\/)?((([a-z0-9][a-z0-9\\-]*[a-z0-9])\\.)?(([a-z0-9][a-z0-9\\-]*[a-z0-9])\\.([a-z]{2,}\\.)*([a-z]{2,})))(\\/.*)?$/i';

        if (preg_match($re, $this->referer, $m)) {
            $this->custom = strtoupper($m[6] . '|' . $m[7]);

            // Assign referer channel
            try {
                // Find a channel by the referer domain
                $this->channel = Channel::whereHas('urls', function ($query) use (&$m) {
                    $query->where('url', $m[7]);
                })->firstOrFail();
            } catch (ModelNotFoundException $e) {
                // No channel?
                // Just use the default channel (first)
                $this->channel = Channel::first();
            }

            // Assign referer agent
            if (!is_null($this->channel)) {
                try {
                    // find an agent that belongs to the referer channel
                    // and contains the subdomain slug
                    $this->agent = $this->channel->agents()->whereHas('slugs', function ($query) use (&$m){
                        $query->where('slug', $m['6']);
                    })->firstOrFail();
                } catch (ModelNotFoundException $e) {
                    // No agent found
                    // Get the default agent for the channel
                    $this->agent = $this->channel->defaultAgent()->first();
                }
            }


            $this->referer = $m[4];
        }
        else {
            // Load Default Store ang Agent;
            $this->channel = Channel::first();
            $this->agent = $this->channel->defaultAgent()->first();
        }

        // Assign a default agent if none is still found
        if (!isset($this->agent)) {
            $this->agent = Agent::first();
        }

        // Force test mode for after Labor Day sale on rt.flavorgod
        if (array_key_exists('6', $m) && array_key_exists('7', $m)) {
            $end_date = Carbon::parse('2016-09-09 03:00:00');
            $full_domain = $m[6].'.'.$m[7];
            if (in_array($full_domain, ['travis.flavorgod.foo', 'rt.flavorgod.com']) && Carbon::now()->lte($end_date)) {
                $this->channel->test_mode = 1;
            }
        }

        return $this;
    }

    public function __construct($orign = '')
    {
        if (!empty($orign)) {
            return $this->setReferer($orign);
        }
    }
}
