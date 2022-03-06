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
    //Special thanks to DaisukeDaisuke with 
    public const LATEST_PHP_BINARY = "https://github.com/DaisukeDaisuke/AndroidPHP/releases/latest/download/php";

    public function process():void {
        $git = shell_exec("git clone ".PocketMineDownloader::POCKETMINE_GITHUB);

        if ($git == true)echo("PocketMine-MP file cloned downloaded..\n");
        sleep(1);

        chdir("PocketMine-MP");
        shell_exec("chmod +x start.sh");
        sleep(1);
        echo("Downloading PocketMine-MP.phar file!\n");
        shell_exec("wget ".PocketMineDownloader::LATEST_RELEAS_PHAR);
        sleep(1);
        echo("Creating bin files..\n");
        shell_exec("mkdir -p bin/php7/bin");
        chdir("bin/php7/bin");

        echo("Downloading PHP BINARY\n");
        $binary = shell_exec("wget ".PocketMineDownloader::LATEST_PHP_BINARY);
        shell_exec("chmod +x php");

        echo("Run ./start.sh\n");
        echo("Bye! Have fun!\n");
        echo("This file will delete automaticly!\n");
        chdir("../../../../");
        unlink(self::FILE_NAME);
        exit();
    }
}

checkWich();

function checkWich() : bool {
    if (stristr(PHP_OS, "LINUX")) {
        echo("If you are using Termux you need to run termux-chroot!\n");
    }
    $WHICH_SERVER = "What do you want do download: \n (1): Nukkit (2): PocketMine-MP\n > ";
    $what = readline($WHICH_SERVER);
    if (!is_int(intval($what))) {
        echo ("The choice must be an integer!\n");
        return false;
    }

    switch ($what) {
        case 1:
            echo("Downloading Nukkit (latest)..! \n");
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
