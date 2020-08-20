<?php

// Prevent e.g. 'Notice: Constant MATH_BIGINTEGER_MONTGOMERY already defined'.
class MyArrayStore extends Doctum\Store\ArrayStore
{
    public function removeClass(Doctum\Project $project, $name)
    {
        unset($this->classes[$name]);
    }
}

$root = realpath(__DIR__) . '/phpseclib/';

$iterator = Symfony\Component\Finder\Finder::create()
    ->files()
    ->name('*.php')
    ->in($root . 'phpseclib');

$versions = Doctum\Version\GitVersionCollection::create($root)
    ->add('1.0')
    ->add('2.0')
    ->add('3.0')
    ->add('master');

return new Doctum\Doctum($iterator, [
    'versions'             => $versions,
    'title'                => 'phpseclib API Documentation',
    'build_dir'            => $root . 'api.phpseclib.org/%version%',
    'cache_dir'            => $root . 'cache/%version%',
    'default_opened_level' => 2,
    'store'                => new MyArrayStore,
    'remote_repository'    => new Doctum\RemoteRepository\GitHubRemoteRepository('phpseclib/phpseclib', $root),
]);
