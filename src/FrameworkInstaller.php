<?php
/**
 * http://docs.phpcomposer.com/articles/custom-installers.html
 */
namespace zhu2688\Composer;

use Composer\Composer;
use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;
use Composer\IO\IOInterface;
// use Composer\Json\JsonFile;
use Composer\Repository\InstalledRepositoryInterface;

class FrameworkInstaller extends LibraryInstaller
{
    public function __construct(IOInterface $io, Composer $composer)
    {
        parent::__construct($io, $composer, null);
    }

    public function getInstallPath(PackageInterface $package)
    {
        // return __DIR__ . '/' . substr($package->getPrettyName(), 23);

        return 'admin/';
        //InstalledRepositoryInterface
    }

    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        $this->initializeVendorDir();
        $downloadPath = $this->getInstallPath($package);
        // remove the binaries if it appears the package files are missing
        if (!is_readable($downloadPath) && $repo->hasPackage($package)) {
            $this->binaryInstaller->removeBinaries($package);
        }
        $this->installCode($package);
        $this->binaryInstaller->installBinaries($package, $this->getInstallPath($package));
        if (!$repo->hasPackage($package)) {
            $repo->addPackage(clone $package);
        }
    }

    // public function installLibrary(PackageInterface $package)
    // {
    //     // Check if silverstripe-recipe type
    //     if ($package->getType() !== RecipePlugin::RECIPE_TYPE) {
    //         return;
    //     }
    //     // Find recipe base dir
    //     $recipePath = $this->getInstallPath($package);
    //     // Find project path
    //     $projectPath = dirname(realpath(Factory::getComposerFile()));
    //     // Find public path
    //     $candidatePublicPath = $projectPath . DIRECTORY_SEPARATOR . RecipePlugin::PUBLIC_PATH;
    //     $publicPath = is_dir($candidatePublicPath) ? $candidatePublicPath : $projectPath;
    //     // Copy project files to root
    //     $name = $package->getName();
    //     $extra = $package->getExtra();
    //     // Install project-files
    //     if (isset($extra[RecipePlugin::PROJECT_FILES])) {
    //         $this->installProjectFiles(
    //             $name,
    //             $recipePath,
    //             $projectPath,
    //             $extra[RecipePlugin::PROJECT_FILES],
    //             RecipePlugin::PROJECT_FILES_INSTALLED,
    //             'project'
    //         );
    //     }
    //     // Install public-files
    //     if (isset($extra[RecipePlugin::PUBLIC_FILES])) {
    //         $this->installProjectFiles(
    //             $name,
    //             $recipePath . '/' . RecipePlugin::PUBLIC_PATH,
    //             $publicPath,
    //             $extra[RecipePlugin::PUBLIC_FILES],
    //             RecipePlugin::PUBLIC_FILES_INSTALLED,
    //             'public'
    //         );
    //     }
    // }
    //
    // protected function installProjectFiles(
    //     $recipe,
    //     $sourceRoot,
    //     $destinationRoot,
    //     $filePatterns,
    //     $registrationKey,
    //     $name = 'project'
    // ) {
    //     // load composer json data
    //     $composerFile = new JsonFile(Factory::getComposerFile(), null, $this->io);
    //     $composerData = $composerFile->read();
    //     $installedFiles = isset($composerData['extra'][$registrationKey])
    //         ? $composerData['extra'][$registrationKey]
    //         : [];
    //     // Load all project files
    //     $fileIterator = $this->getFileIterator($sourceRoot, $filePatterns);
    //     $any = false;
    //     foreach ($fileIterator as $path => $info) {
    //         // Write header on first file
    //         if (!$any) {
    //             $this->io->write("Installing {$name} files for recipe <info>{$recipe}</info>:");
    //             $any = true;
    //         }
    //         // Install this file
    //         $relativePath = $this->installProjectFile($sourceRoot, $destinationRoot, $path, $installedFiles);
    //         // Add file to installed (even if already exists)
    //         if (!in_array($relativePath, $installedFiles)) {
    //             $installedFiles[] = $relativePath;
    //         }
    //     }
    //     // If any files are written, modify composer.json with newly installed files
    //     if ($installedFiles) {
    //         sort($installedFiles);
    //         if (!isset($composerData['extra'])) {
    //             $composerData['extra'] = [];
    //         }
    //         $composerData['extra'][$registrationKey] = $installedFiles;
    //         $composerFile->write($composerData);
    //     }
    // }

    public function supports($packageType)
    {
        return 'framework-installer' === $packageType;
    }
}
