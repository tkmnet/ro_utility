<?php

namespace rrsoacis\apps\tkmnet\ro_utility;

use rrsoacis\component\common\AbstractPage;
use rrsoacis\system\Config;

class ScoreCalcPage extends AbstractPage
{
	private $bases;
	private $base = null;
	private $cmd = '';
	private $results = "";

	public function controller($params)
	{
		if (count($params) == 1) {
			if ($params[0] === "calc" && isset($_POST["input"])) {
				$input = explode("\n", $_POST["input"]);
				$input = array_map('trim', $input);
				$input = array_filter($input, 'strlen');
				$input = array_values($input);

				/*
				foreach ($input as $value) {
					$item = explode(",", $value);
					$item = array_map('trim', $item);
					if (count($item) == 2) {
					}
				}
				 */

				$mapScores = $input;
				$mapPoints = self::calcPoints($mapScores);

				$this->results .= '<table class="table"><thead><tr><th>Score</th><th>Point</th></tr></thead>';

				for ($i = 0; $i < count($mapScores); $i++)
				{
					$this->results .= '<tr><td>'.$mapScores[$i].'</td><td>'.$mapPoints[$i].'</td></tr>';
				}
				$this->results .= '</table>';
			}
		}

		$this->setTitle("ScoreCalculator");
		$this->printPage();
	}

	function body()
	{
		self::writeContentHeader("UtilityTools", "ScoreCalculator", ["<a href='/app/tkmnet/ro_utility'>UtilityTools</a>"]);
		self::beginContent();
		self::printForm();
		self::endContent();
	}

	function printForm()
	{
	?>
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Results</h3>
			</div>
			<div class="box-body table-responsive no-padding">
			<?= $this->results ?>
			</div>
			<!-- /.box-body -->
		</div>
		<div class="box box-warning">
			<div class="box-header with-border">
			</div>

			<form id="add_parameter-form" action="/app/tkmnet/ro_utility-scorecalc/calc" method="POST"
						class="form-horizontal">
				<div class="box-body">
					<div class="form-group">
						<label for="note" class="col-sm-2 control-label">CSV</label>
						<div class="col-sm-10">
						<textarea class="form-control" id="input" name="input" rows="16"><?= (isset($_POST["input"])?$_POST["input"]:"") ?></textarea>
						</div>
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<button type="submit" class="btn btn-primary pull-right">Calc</button>
				</div>
				<!-- /.box-footer -->
				<input type="hidden" name="action" value="create">
			</form>
		</div>
		<!-- /.box -->
<?php
	}

	function calcPoints($sc)
	{
		$scoresHash = array();
		$key = 0;
		foreach ($sc as $score)
		{ $scoresHash[$key++] = $score; }
		arsort($scoresHash, SORT_NUMERIC);

		$n = count($sc);
		$sdc = 2;
		$sm = max($sc) - ((max($sc) - self::mean($sc)) *2);
		$ms = $n * $sdc;
		$mss = [];
		$mss[0] = 0;
		for ($step = 1; $step <= $ms; $step++) // Division by zero
		{
			//$mss[$step] = ((max($sc) - $sm) / $ms) * ($ms - $step);
			//$mss[$step] = (max($sc) - $sm) / ($ms * ($ms - $step));
			$mss[$step] = max($sc) - ((max($sc) - $sm) / $ms * ($ms - $step));
		}

		$pointsHash = array();
		$usedStep = $ms +1;
		foreach ($scoresHash as $key => $score)
		{
			$step = 1;
			for (; $step <= $ms && $score > $mss[$step]; $step++) { }
			if ($step < $ms) { $step--; }
			if ($usedStep <= $step) { $step --; }
			if ($step <= 1) { $step = 1; }
			$usedStep = $step;
			if (max($sc) == $score) { $step = $ms; }
			$pointsHash[$key] = $step;
		}

		ksort($pointsHash);
		$points = [];
		foreach ($pointsHash as $key => $point)
		{ $points[] = $point; }

		return $points;
	}

	private static function mean($array)
	{
		$count = count($array); 
		if ($count <= 0) { return 0; }
		$sum = array_sum($array); 
		return $sum / $count; 
	}

}
