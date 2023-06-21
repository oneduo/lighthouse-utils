<?php

declare(strict_types=1);

namespace Oneduo\LighthouseUtils;

use Closure;
use Laravel\Pennant\Feature;

class LighthouseUtils
{
    protected ?Closure $featureValueResolver = null;

    public function resolveFeatureValueUsing(Closure $closure): static
    {
        $this->featureValueResolver = $closure;

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function resolveFeatureValue(string $name): bool
    {
        if ($this->featureValueResolver) {
            return call_user_func($this->featureValueResolver, $name);
        }

        if (!class_exists('Laravel\\Pennant\\Feature')) {
            throw new \Exception('You must provide a feature resolver or install Laravel Pennant');
        }

        return Feature::active($name);
    }
}
