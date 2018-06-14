<?php
/**
 * http://docs.phpcomposer.com/articles/custom-installers.html
 */
namespace zhu2688\Composer;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class FrameworkInstaller extends LibraryInstaller
{
    public function getInstallPath(PackageInterface $package)
    {
        return 'admin/';
    }

    public function supports($packageType)
    {
        return 'framework-installer' === $packageType;
    }
}
