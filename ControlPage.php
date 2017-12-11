<?php

namespace rrsoacis\apps\tkmnet\ro_utility;

use rrsoacis\component\common\AbstractPage;
use rrsoacis\manager\ClusterManager;
use rrsoacis\manager\component\Cluster;
use rrsoacis\system\Config;

class ControlPage extends AbstractPage
{
	public function controller($params)
	{
		$param_count = count($params);

		if ($param_count <= 0) {
			header('location: '.Config::$TOP_PATH.'app/tkmnet/ro_utility');
			return;
		}

		$cmd = $params[0];

		if ($cmd === "batchsetup") {
			foreach (ClusterManager::getClusters() as $raw_cluster) {
				$cluster = new Cluster($raw_cluster);
				if ( $cluster->check_status != Cluster::STATUS_DISABLED ) {
					ClusterManager::updateCluster($cluster->name,
						$cluster->a_host, $cluster->f_host, $cluster->p_host, $cluster->s_host,
						$cluster->archiver, $_POST['hosts_pass']);
				}
			}
		}

		header('location: '.Config::$TOP_PATH.'app/tkmnet/ro_utility');
	}
}
