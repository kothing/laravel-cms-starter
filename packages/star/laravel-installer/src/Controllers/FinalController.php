<?php

namespace Star\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use Star\LaravelInstaller\Events\LaravelInstallerFinished;
use Star\LaravelInstaller\Helpers\EnvironmentManager;
use Star\LaravelInstaller\Helpers\FinalInstallManager;
use Star\LaravelInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param  \Star\LaravelInstaller\Helpers\InstalledFileManager  $fileManager
     * @param  \Star\LaravelInstaller\Helpers\FinalInstallManager  $finalInstall
     * @param  \Star\LaravelInstaller\Helpers\EnvironmentManager  $environment
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
