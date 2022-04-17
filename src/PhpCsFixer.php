<?php

declare(strict_types=1);

namespace Yediyuz\DevTools;

use Closure;
use PhpCsFixer\Config as PhpCsFixerConfig;
use PhpCsFixer\ConfigInterface;
use PhpCsFixer\Finder;

class PhpCsFixer
{
    private PhpCsFixerConfig $config;

    private Finder $finder;

    public function __construct(private string $type, private string $dir)
    {
        $this->config = (new PhpCsFixerConfig)
            ->setRiskyAllowed(true)
            ->setUsingCache(true);

        $this->finder = Finder::create();
        $this->finder();
        $this->rules();
    }

    public static function php(string $dir): static
    {
        return new static('php', $dir);
    }

    public static function laravelApp(string $dir): static
    {
        return new static('laravel-app', $dir);
    }

    public static function laravelPackage(string $dir): static
    {
        return new static('laravel-package', $dir);
    }

    public function withFinder(Closure $callback): static
    {
        $this->config->setFinder($callback(Finder::create()));

        return $this;
    }

    public function withCustomFinder(Finder $finder): static
    {
        $this->finder = $finder;

        return $this;
    }

    public function finder(?Closure $finder = null): static
    {
        $this->finder = match ($this->type) {
            'php'             => $this->getDefaultPhpFinder($finder),
            'laravel-app'     => $this->getDefaultLaravelAppFinder($finder),
            'laravel-package' => $this->getDefaultLaravelPackageFinder($finder),
        };

        return $this;
    }

    private function getDefaultLaravelPackageFinder(?Closure $callback): Finder
    {
        $finder = $this->finder->notPath('coverage')
                               ->notPath('vendor')
                               ->in([
                                   $this->dir . '/src',
                                   $this->dir . '/config',
                                   $this->dir . '/tests',
                               ])
                               ->name('*.php')
                               ->notName('*.blade.php')
                               ->ignoreDotFiles(true)
                               ->ignoreVCS(true);

        if (is_null($callback)) {
            return $finder;
        }

        return $callback($finder);
    }

    private function getDefaultLaravelAppFinder(?Closure $callback): Finder
    {
        $finder = $this->finder->notPath('bootstrap/*')
                               ->notPath('storage/*')
                               ->notPath('vendor')
                               ->in([
                                   $this->dir . '/app',
                                   $this->dir . '/config',
                                   $this->dir . '/database',
                                   $this->dir . '/resources',
                                   $this->dir . '/routes',
                                   $this->dir . '/lang',
                                   $this->dir . '/tests',
                               ])
                               ->name('*.php')
                               ->notName('*.blade.php')
                               ->ignoreDotFiles(true)
                               ->ignoreVCS(true);

        if (is_null($callback)) {
            return $finder;
        }

        return $callback($finder);
    }

    private function getDefaultPhpFinder(?Closure $callback): Finder
    {
        $finder = $this->finder->notPath('vendor')
                               ->in([
                                   $this->dir . '/src',
                                   $this->dir . '/tests',
                               ])
                               ->name('*.php')
                               ->ignoreDotFiles(true)
                               ->ignoreVCS(true);

        if (is_null($callback)) {
            return $finder;
        }

        return $callback($finder);
    }

    public function rules(?Closure $callback = null): static
    {
        $rulesInstance = (new PhpCsFixerRules());

        if (is_null($callback)) {
            $rules = $rulesInstance->get();
        } else {
            $rules = $callback($rulesInstance)->get();
        }

        $this->config->setRules($rules);

        return $this;
    }

    public function config(Closure $callback): static
    {
        $this->config = $callback($this->config);

        return $this;
    }

    public function build(): ConfigInterface
    {
        $this->config->setFinder($this->finder);

        return $this->config;
    }
}