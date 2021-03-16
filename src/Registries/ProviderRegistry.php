<?php

declare(strict_types=1);

namespace Tipoff\Seo\Registries;

use Tipoff\Support\TipoffServiceProvider;

class ProviderRegistry
{
    protected array $providers = [];

    /**
     * @param TipoffServiceProvider $instance
     * return $this
     */

    public function registerProvider(TipoffServiceProvider $instance): self
    {
        $this->providers[$instance->name()] = $instance;

        return $this;
    }

    /**
     * @param string $name
     * return TipoffServiceProvider $provider
     */

    public function getProvider(string $name)
    {
        $provider = $this->providers[$name];

        return $provider;
    }
}