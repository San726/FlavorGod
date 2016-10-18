<?php namespace Flavorgod\Models\Repository;

use FitlifeGroup\Models\Eloquent\Agent;
use Exception;

trait DistinguishesAgent
{
    protected $agent;

    protected function throwIfNoAgent()
    {
        if (isset($his->agent) && $this->agent instanceof Agent) {
            return;
        }

        throw new Exception('No agent selected.');
    }

    public function setAgent($agent)
    {
        if ($agent instanceof Agent) {
            $this->agent = $agent;
        } elseif (is_numeric($agent)) {
            $this->agent = Agent::find($agent);
        }

        return $this;
    }

    public function getAgent()
    {
        return $this->agent;
    }
}