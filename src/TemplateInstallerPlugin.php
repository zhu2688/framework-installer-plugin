<?php
/**
 * http://docs.phpcomposer.com/articles/custom-installers.html
 */
namespace zhu2688\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class FrameworkInstallerPlugin implements PluginInterface
{
    public function activate(Composer $composer, IOInterface $io)
    {
        $installer = new FrameworkInstaller($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);
    }
}
