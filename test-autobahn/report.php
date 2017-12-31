<?php

require dirname(__DIR__) . "/vendor/autoload.php";

const REPORT_PATH = __DIR__ . "/reports/servers/index.json";

$climate = new League\CLImate\CLImate;

if (!file_exists(REPORT_PATH)) {
    $climate->red("Could not find autobahn test results json file");
    exit(1);
}

$report = file_get_contents(REPORT_PATH);
$report = json_decode($report, true);

if (!isset($report["Aerys"])) {
    $climate->red("Could not find result set for Aerys");
}

$report = $report["Aerys"];

$climate->out("Autobahn test report:");

$passed = 0;
$nonstrict = 0;
$failed = 0;
$total = 0;

foreach ($report as $testNumber => $result) {
    $message = \sprintf("%9s: %s ", $testNumber, $result["behavior"]);

    switch ($result["behavior"]) {
        case "OK":
            $passed++;
            $climate->green($message);
            break;

        case "NON-STRICT":
            $nonstrict++;
            $climate->yellow($message);
            break;

        case "FAILED":
            $failed++;
            $climate->red($message);
            break;

        default:
            $climate->blue($message);
            break;
    }
}

$climate->br();

$total = $passed + $nonstrict + $failed;
$counts = \sprintf("%d Total / %d Passed / %d Non-strict / %d Failed", $total, $passed, $nonstrict, $failed);

if ($failed) {
    $climate->backgroundRed()->black(\sprintf(" Tests failed: %s ", $counts));
} elseif ($nonstrict) {
    $climate->backgroundYellow()->black(\sprintf(" Tests passed: %s ", $counts));
} else {
    $climate->backgroundGreen()->black(\sprintf(" Tests passed: %s ", $counts));
}

exit($failed === 0 ? 0 : 1);
