<?php

namespace NovaTesting;

use NovaTesting\NovaResponse;

trait NovaRequests
{
    public function novaIndex($resource)
    {
        return new NovaResponse(
            $this->getJson("nova-api/$resource")
        );
    }

    public function novaDetail($resource, $id)
    {
        return new NovaResponse(
            $this->getJson("nova-api/$resource/$id")
        );
    }
}
