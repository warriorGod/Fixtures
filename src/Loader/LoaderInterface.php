<?php declare(strict_types=1);

namespace DavidBadura\Fixtures\Loader;

use DavidBadura\Fixtures\Fixture\FixtureCollection;

/**
 * @author David Badura <d.badura@gmx.de>
 */
interface LoaderInterface
{
    public function load($path, array $options = []): FixtureCollection;
}
