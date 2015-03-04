<?php

/**
 * This file is part of the JoliNotif project.
 *
 * (c) Loïck Piera <pyrech@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JoliNotif\Driver;

use JoliNotif\Notification;
use JoliNotif\Util\OsHelper;
use Symfony\Component\Process\ProcessBuilder;

/**
 * This driver can be used on Mac OS X 10.8, or higher, using the terminal-notifier binary.
 */
class TerminalNotifierDriver extends CliBasedDriver
{
    /**
     * {@inheritdoc}
     */
    public function getBinary()
    {
        return 'terminal-notifier';
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return static::PRIORITY_MEDIUM;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureProcess(ProcessBuilder $processBuilder, Notification $notification)
    {
        $processBuilder->add('-message');
        $processBuilder->add($notification->getBody());

        if ($notification->getTitle()) {
            $processBuilder->add('-title');
            $processBuilder->add($notification->getTitle());
        }

        if ($notification->getIcon() && version_compare(OsHelper::getMacOSVersion(), '10.9.0', '>=')) {
            $processBuilder->add('-appIcon');
            $processBuilder->add($notification->getIcon());
        }
    }
}
