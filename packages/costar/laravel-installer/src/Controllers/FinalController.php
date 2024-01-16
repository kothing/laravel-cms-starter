<?php

namespace Costar\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use Costar\LaravelInstaller\Events\LaravelInstallerFinished;
use Costar\LaravelInstaller\Helpers\EnvironmentManager;
use Costar\LaravelInstaller\Helpers\FinalInstallManager;
use Costar\LaravelInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param  \Costar\LaravelInstaller\Helpers\InstalledFileManager  $fileManager
     * @param  \Costar\LaravelInstaller\Helpers\FinalInstallManager  $finalInstall
     * @param  \Costar\LaravelInstaller\Helpers\EnvironmentManager  $environment
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
