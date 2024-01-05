<?php

namespace LocalStore\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use LocalStore\LaravelInstaller\Events\LaravelInstallerFinished;
use LocalStore\LaravelInstaller\Helpers\EnvironmentManager;
use LocalStore\LaravelInstaller\Helpers\FinalInstallManager;
use LocalStore\LaravelInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param  \LocalStore\LaravelInstaller\Helpers\InstalledFileManager  $fileManager
     * @param  \LocalStore\LaravelInstaller\Helpers\FinalInstallManager  $finalInstall
     * @param  \LocalStore\LaravelInstaller\Helpers\EnvironmentManager  $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('installer.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
