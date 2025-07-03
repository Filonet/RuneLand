<?php

declare(strict_types=1);

namespace PlayerData\mysql;

use PlayerData\data\AuthData;
use PlayerData\data\GroupData;
use PlayerData\data\PlayerData;
use PlayerData\data\ProfessionData;
use PlayerData\data\QuestData;
use PlayerData\data\StatsData;
use PlayerData\data\TeleportData;
use PlayerData\types\SessionIds;
use PlayerData\types\StaticQuestData;
use PlayerData\types\TeleportDataHome;
use pmmp\thread\ThreadSafeArray;
use pocketmine\thread\Thread;

class MysqlThread extends Thread{

    protected ThreadSafeArray $dataRequests;
    protected ThreadSafeArray $dataResults;
    protected ThreadSafeArray $queries;

    protected ThreadSafeArray $queriesClosureInput;
    protected ThreadSafeArray $queriesClosureOutput;

    public function __construct(
        protected int $port
    ){
        $this->dataRequests = new ThreadSafeArray();
        $this->dataResults = new ThreadSafeArray();
        $this->queries = new ThreadSafeArray();

        $this->queriesClosureInput = new ThreadSafeArray();
        $this->queriesClosureOutput = new ThreadSafeArray();

        $this->setClassLoaders();
    }

    public function onRun() : void{
        $this->registerClassLoaders();
        gc_enable();

        $db = MySQLManager::runeland();

        while (!$this->isKilled) {
            $start = microtime(true);

            try {
                if (!$db->ping()) {
                    $db = MySQLManager::runeland();

                    \GlobalLogger::get()->warning("Rebuilt MySQL query (HypeGO)");
                }

                while (($query = $this->readQueryPacket()) !== null) {
                    $db->query($query);
                }

                while (([$query, $closure] = $this->readQueryClosureInputPacket()) !== null) {
                    $result = $db->query($query)->fetch_all();

                    $this->pushQueryClosureOutputPacket($result, $closure);
                }

                do {
                    $players = [];
                    while (($entry = $this->readDataRequestPacket()) !== null && $entry !== false) {
                        $players[] = $entry;
                    }

                    if (count($players) === 0) {
                        break;
                    }
                    $result = [];

                    foreach ($players as $data) {
                        $result[$data[0]] = PlayerData::make();
                    }

                    $querySeq = implode(" OR ", array_map(function ($n) {
                        return "`name`=\"" . $n[0] . "\"";
                    }, $players));

                    $q = $db->query("SELECT `nickname`, `group`, `expirationGroup`, `title` FROM `groups` WHERE " . str_replace("`name`", "`nickname`", $querySeq));
                    if ($q !== false && count($data = $q->fetch_all())) {
                        foreach ($data as $row) {
                            $result[trim(strtolower($row[0]))]->setGroupData(new GroupData($row[1], (int) $row[2], $row[3]));
                        }
                    }

                    $q = $db->query("SELECT `nickname`, `money`, `runes`, `kills`, `deaths`, `gameTime` FROM `stats` WHERE " . str_replace("`name`", "`nickname`", $querySeq));
                    if ($q !== false && count($data = $q->fetch_all())) {
                        foreach ($data as $row) {
                            $result[trim(strtolower($row[0]))]->setStatsData(new StatsData((int)$row[1], (int)$row[2], (int)$row[3], (int)$row[4], (int)$row[5]));
                        }
                    }

                    $q = $db->query("SELECT `nickname`, `password`, `address` FROM `auth` WHERE " . str_replace("`name`", "`nickname`", $querySeq));
                    if ($q !== false && count($data = $q->fetch_all())) {
                        foreach ($data as $row) {
                            $result[trim(strtolower($row[0]))]->setAuthData(new AuthData(
                                (string)$row[1],
                                (string)$row[2],
                                SessionIds::LOGIN
                            ));
                        }
                    }

                    $q = $db->query("SELECT `nickname`, `homes` FROM `teleport` WHERE " . str_replace("`name`", "`nickname`", $querySeq));
                    if ($q !== false && count($data = $q->fetch_all())) {
                        foreach ($data as $row) {
                            $homes = [];
                            $jsonHomes = json_decode($row[1], true);
                            foreach ($jsonHomes as $name => [$x, $y, $z]) {
                                $homes[$name] = new TeleportDataHome($name, $x, $y, $z);
                            }

                            $result[trim(strtolower($row[0]))]->setTeleportData(new TeleportData($homes));
                        }
                    }

                    $q = $db->query("SELECT `nickname`, `questId`, `isTake`, `progress` FROM `questWoodcutter` WHERE " . str_replace("`name`", "`nickname`", $querySeq));
                    if ($q !== false && count($data = $q->fetch_all())) {
                        foreach ($data as $row) {
                            $result[trim(strtolower($row[0]))]->getQuestData()->setWoodcutter(new StaticQuestData((int) $row[1], boolval($row[2]), (float) $row[3]));
                        }
                    }

                    $q = $db->query("SELECT `nickname`, `questId`, `isTake`, `progress` FROM `questMiner` WHERE " . str_replace("`name`", "`nickname`", $querySeq));
                    if ($q !== false && count($data = $q->fetch_all())) {
                        foreach ($data as $row) {
                            $result[trim(strtolower($row[0]))]->getQuestData()->setMiner(new StaticQuestData((int) $row[1], boolval($row[2]), (float) $row[3]));
                        }
                    }

                    $q = $db->query("SELECT `nickname`, `questId`, `isTake`, `progress` FROM `questHunter` WHERE " . str_replace("`name`", "`nickname`", $querySeq));
                    if ($q !== false && count($data = $q->fetch_all())) {
                        foreach ($data as $row) {
                            $result[trim(strtolower($row[0]))]->getQuestData()->setHunter(new StaticQuestData((int) $row[1], boolval($row[2]), (float) $row[3]));
                        }
                    }

                    $q = $db->query("SELECT `nickname`, `questId`, `isTake`, `progress` FROM `questFarmer` WHERE " . str_replace("`name`", "`nickname`", $querySeq));
                    if ($q !== false && count($data = $q->fetch_all())) {
                        foreach ($data as $row) {
                            $result[trim(strtolower($row[0]))]->getQuestData()->setFarmer(new StaticQuestData((int) $row[1], boolval($row[2]), (float) $row[3]));
                        }
                    }

                    $q = $db->query("SELECT `nickname`, `level`, `experience` FROM `profession` WHERE " . str_replace("`name`", "`nickname`", $querySeq));
                    if ($q !== false && count($data = $q->fetch_all())) {
                        foreach ($data as $row) {
                            $result[trim(strtolower($row[0]))]->setProfessionData(new ProfessionData((int) $row[1], (int) $row[2]));
                        }
                    }

                    foreach ($players as $data) {
                        $result[$data[0]]->setCid(intval($data[1]));
                    }

                    $this->pushDataResultPacket($result);
                } while (false);

                $time = microtime(true) - $start;
                if ($time < 0.024) {
                    @time_sleep_until(microtime(true) + 0.025 - $time);
                }
            } catch (\Throwable|\Exception $exception) {
                $db = MySQLManager::runeland();

                \GlobalLogger::get()->error("Rebuilt MySQL query (HypeGO)");
                \GlobalLogger::get()->error("Error: " . $exception);
            }
        }
    }

    /**
     * @param array $data
     */
    public function pushDataRequestPacket(array $data){
        $this->dataRequests[] = igbinary_serialize($data);
    }

    public function readDataRequestPacket(){
        if (($data = $this->dataRequests->shift()) !== NULL) {
            return igbinary_unserialize($data);
        }
        return null;
    }

    /**
     * @param mixed $data
     */
    public function pushDataResultPacket($data){
        $this->dataResults[] = igbinary_serialize($data);
    }

    /**
     * @return mixed
     */
    public function readDataResultPacket(){
        if (($data = $this->dataResults->shift()) !== NULL) {
            return igbinary_unserialize($data);
        }
        return null;
    }

    /**
     * @param string $query
     */
    public function pushQueryPacket(string $query){
        $this->queries[] = $query;
    }

    /**
     * @return string
     */
    public function readQueryPacket(){
        return $this->queries->shift();
    }

    public function pushQueryClosureInputPacket(string $query, \Closure $closure){
        $this->queriesClosureInput[] = igbinary_serialize([$query, SaveClosureData::addClosure($closure)]);
    }

    public function readQueryClosureInputPacket(){
        if (($data = $this->queriesClosureInput->shift()) !== NULL) {
            return igbinary_unserialize($data);
        }
        return null;
    }

    public function pushQueryClosureOutputPacket($result, $closure){
        $this->queriesClosureOutput[] = igbinary_serialize([$result, $closure]);
    }

    public function readQueryClosureOutputPacket(){
        if (($data = $this->queriesClosureOutput->shift()) !== NULL) {
            [$result, $closureId] = igbinary_unserialize($data);
            $closure = SaveClosureData::getClosure($closureId);
            SaveClosureData::removeClosure($closureId);
            return [$result, $closure];
        }
        return null;
    }
}
