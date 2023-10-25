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

    public function __construct(private readonly string $type, private readonly string $dir, private array $dirs)
    {
        $this->config = (new PhpCsFixerConfig)
            ->setRiskyAllowed(true)
            ->setUsingCache(true);

        $this->finder = Finder::create();
    }

    private static function dirsFilter(array $dirs): array
    {
        return array_filter($dirs, static function ($dir) {
            return filled(glob($dir));
        });
    }

    public static function php(string $dir): static
    {
        $dirs = [
            $dir . '/src',
            $dir . '/tests',
        ];
        return new static('php', $dir, self::dirsFilter($dirs));
    }

    public static function laravelApp(string $dir): static
    {
        $dirs = [
            $dir . '/app',
            $dir . '/config',
            $dir . '/database',
            $dir . '/resources',
            $dir . '/routes',
            $dir . '/lang',
            $dir . '/tests',
        ];
        return new static('laravel-app', $dir, self::dirsFilter($dirs));
    }

    public static function laravelPackage(string $dir): static
    {
        $dirs = [
            $dir . '/src',
            $dir . '/config',
            $dir . '/tests',
        ];
        return new static('laravel-package', $dir, self::dirsFilter($dirs));
    }

    public function excludeDir(string $folderName): static
    {
        $this->dirs = collect($this->dirs)->flip()->forget($this->dir . '/' . $folderName)->flip()->toArray();

        return $this;
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
            'php' => $this->getDefaultPhpFinder($finder),
            'laravel-app' => $this->getDefaultLaravelAppFinder($finder),
            'laravel-package' => $this->getDefaultLaravelPackageFinder($finder),
        };

        return $this;
    }

    private function getDefaultLaravelPackageFinder(?Closure $callback): Finder
    {
        $finder = $this->finder->notPath('coverage')
                               ->notPath('vendor')
                               ->in($this->dirs)
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
                               ->in($this->dirs)
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
                               ->in($this->dirs)
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

    public function build(?Closure $finderCallback = null, ?Closure $rulesCallback = null): ConfigInterface
    {
        $this->finder($finderCallback);
        $this->rules($rulesCallback);
        $this->config->setFinder($this->finder);

        return $this->config;
    }
}