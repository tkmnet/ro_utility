<?php

namespace rrsoacis\apps\tkmnet\ro_utility;

use rrsoacis\component\common\AbstractPage;
use rrsoacis\manager\ScriptManager;
use rrsoacis\system\Config;

class RestartOacisPage extends AbstractPage
{
	private $bases;
	private $base = null;
	private $cmd = '';
	public function controller($params)
	{
		$this->setTitle("RestartOacis");
		$this->printPage();
	}

	function body()
	{
		self::writeContentHeader("RestartOacis", "RestartOacis", ["<a href='/app/tkmnet/ro_utility'>UtilityTools</a>"]);
		self::beginContent();
		$this->writeBatchSetup();
		self::endContent();
	}

	function writeBatchSetup()
	{
		ScriptManager::queueBashScript("bash /home/oacis/rrs-oacis/apps/tkmnet/ro_utility/restart_oacis.sh");
		?>
		<meta http-equiv="refresh" content="3;URL=./ro_utility">
<h1>
Restarting OACIS requested...
</h1>
		<?php
	}
}
