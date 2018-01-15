<?php

namespace rrsoacis\apps\tkmnet\ro_utility;

use rrsoacis\component\common\AbstractPage;
use rrsoacis\system\Config;

class MainPage extends AbstractPage
{
	private $bases;
	private $base = null;
	private $cmd = '';
	public function controller($params)
	{
		$this->setTitle("UtilityTools");
		$this->printPage();
	}

	function body()
	{
		self::writeContentHeader("UtilityTools");
		self::beginContent();
		$this->writeBatchSetup();
		self::endContent();
	}

	function writeBatchSetup()
	{
		?>
		<div class="row">
			<div class="col-xs-12">
				<div class="box collapsed-box">
					<div class="box-header with-border">
						<h3 class="box-title">
							Batch setup
							<small></small>
						</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
							</button>
						</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<form id="post-form" action="<?= Config::$TOP_PATH . "app/tkmnet/ro_utility-control/batchsetup" ?>" method="POST"
									class="form-horizontal">
							<div class="input-group pull-right">
								<input class="form-control" placeholder="Hosts password" name="hosts_pass" type="password" value="">
								<span class="input-group-btn"> <input class="btn" type="submit" value="Run"> </span>
							</div>
						</form>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            WatchDog
                            <small></small>
                        </h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form id="post-form" action="<?= Config::$TOP_PATH . "app/tkmnet/ro_utility-watchdog" ?>" method="POST"
                              class="form-horizontal">
                            <input class="btn" type="submit" value="Start">
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
		<?php
	}
}
