<?php

declare(strict_types=1);

namespace Randock\AdminPressBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Randock\AdminPressBundle\DependencyInjection\Compiler\MainMenuPass;
use Randock\AdminPressBundle\DependencyInjection\Compiler\ProfileMenuPass;
use Randock\AdminPressBundle\DependencyInjection\Compiler\NotificationsPass;

class RandockAdminPressBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new MainMenuPass());
        $container->addCompilerPass(new ProfileMenuPass());
        $container->addCompilerPass(new NotificationsPass());
    }
}
