<?php

namespace rrsoacis\apps\tkmnet\ro_utility;

use rrsoacis\component\common\AbstractPage;
use rrsoacis\manager\ScriptManager;
use rrsoacis\system\Config;

class WatchDogPage extends AbstractPage
{
	private $bases;
	private $base = null;
	private $cmd = '';
	public function controller($params)
	{
		$this->setTitle("WatchDog");
		$this->printPage();
	}

	function body()
	{
		self::writeContentHeader("WatchDog");
		self::beginContent();
		$this->writeBatchSetup();
		self::endContent();
	}

	function writeBatchSetup()
	{
        $hosts = json_decode(file_get_contents("http://localhost:3000/runs/_jobs_table.json?run_status=running&length=100"), true);
        foreach ($hosts["data"] as $host) {
            $runid = substr($host[0], 7 + strpos($host[0], 'value="'), 24);
            if (substr($host[9], -1 * strlen(" h ago")) === " h ago") {
                //exec("nohup /home/oacis/oacis/bin/oacis_cli replace_runs_by_ids ". $runid . " >/dev/null 2>&1 &");
                //usleep(100000);
                ScriptManager::queueBashScript("/home/oacis/oacis/bin/oacis_ruby /home/oacis/rrs-oacis/ruby/repost.rb ". $runid);
                print("[Repost] ");
            }
            print($runid . "(" . $host[9] . ")<br>");
        }
		?>
		<meta http-equiv="refresh" content="120;URL=./ro_utility-watchdog">
		<?php
	}
}
