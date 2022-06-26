<?php

interface Downloader {

    public const FILE_NAME = "download.php";

    public function process():void;

}

class NukkitDownloader implements Downloader {

    public const JENKINS = "https://ci.opencollab.dev//job/NukkitX/job/Nukkit/job/master/lastSuccessfulBuild/artifact/target/nukkit-1.0-SNAPSHOT.jar";

    public const JAR_FILE = "nukkit-1.0-SNAPSHOT.jar";

    public function process() : void {
        $exec = shell_exec("wget ".NukkitDownloader::JENKINS);

        if ($exec == true)sleep(1);
        echo("Creating start.sh file!\n");
        $content = "java -Xms2G -Xms2G -jar ".NukkitDownloader::JAR_FILE;
        file_put_contents("start.sh", $content);
        shell_exec("chmod +x start.sh");

        echo("Run ./start.sh\n");
        echo("Bye! Have fun!\n");
        echo("This file will delete automaticly!\n");
        sleep(1);
        unlink(self::FILE_NAME);
        exit();
    }
}

class PocketMineDownloader implements Downloader {

    public const POCKETMINE_GITHUB = "https://github.com/pmmp/PocketMine-MP/";

    public const LATEST_RELEAS_PHAR = "https://github.com/pmmp/PocketMine-MP/releases/latest/download/PocketMine-MP.phar";
    //Special thanks to DaisukeDaisuke
    public const LATEST_PHP_BINARY = "https://github.com/DaisukeDaisuke/AndroidPHP/releases/latest/download/php";

    public function process():void {
        $git = shell_exec("git clone ".PocketMineDownloader::POCKETMINE_GITHUB);

        if ($git == true)echo("\033[1;32mDownloaded PocketMine MP file cloned.\033[0m\n");
        sleep(1);

        chdir("PocketMine-MP");
        shell_exec("chmod +x start.sh");
        sleep(1);
        shell_exec("wget ".PocketMineDownloader::LATEST_RELEAS_PHAR);
        sleep(1);
        shell_exec("mkdir -p bin/php7/bin");
        chdir("bin/php7/bin");

        $binary = shell_exec("wget ".PocketMineDownloader::LATEST_PHP_BINARY);
        shell_exec("chmod +x php");

        echo("\033[1;32mRun ./start.sh\033[0m\n");
        echo("\033[1;32mBye! Have fun!\033[0m\n");
        echo("\033[1;32mThis file will delete automaticly!\033[0m\n");
        chdir("../../../../");
        unlink(self::FILE_NAME);
        exit();
    }
}
system("clear");
print_logo();
checkWich();

function checkWich() : bool {
    if (stristr(PHP_OS, "LINUX")) {
        echo("\033[0;31mIf you use Termux, you must run termux-chroot!\033[0m\n");
    }
    $WHICH_SERVER = "What do you want to do download: \n(1): Nukkit (2): PocketMine-MP\n > ";
    $what = readline($WHICH_SERVER);
    if (!is_int(intval($what))) {
        echo ("The choice must be a number!\n");
        return false;
    }
    
    system("clear");
    switch ($what) {
        case 1:
            echo("Downloading Nukkit (latest)..!\n");
            $nukkit = new NukkitDownloader();
            $nukkit->process();
            break;

        case 2:
            echo("Downloading PocketMine-MP (latest)..!\n");
            $pocketmine = new PocketMineDownloader();
            $pocketmine->process();
            break;
    }
    return true;

}

function print_logo() {
    echo("\033[1;34m
           _____ _____ _____             __  __ \n
          / ____/ ____|  __ \           /_ |/_ |\n
         | (___| (___ | |  | |     __   _| | | |\n
          \___ \\___ \| |  | |     \ \ / / | | |\n
          ____) |___) | |__| |      \ V /| | | |\n
         |_____/_____/|_____/        \_/ |_(_)_|\n  
   \033[0m\n");
}