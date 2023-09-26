<?php

class CoordinatesValidator
{
    private $x;
    private $y;
    private $r;

    public function __construct($x, $y, $r)
    {
        $this->x = $x;
        $this->y = $y;
        $this->r = $r;
    }

    public function checkData()
    {
        return $this->checkX() && $this->checkY() && $this->checkR();
    }

    private function checkX()
    {
        return in_array($this->x, array(-5, -4, -3, -2, -1, 0, 1, 2, 3));
    }

    private function checkY()
    {
        return is_numeric($this->y) && ($this->y > -5 && $this->y < 3);
    }

    private function checkR()
    {
        return in_array($this->r, array(1, 1.5, 2, 2.5, 3));
    }
}

class HitPoint
{
    private $x;
    private $y;
    private $r;

    function __construct($x, $y, $r)
    {
        $this->x = $x;
        $this->y = $y;
        $this->r = $r;
    }

    function checkSquare()
    {
        return ($this->x >= 0 && $this->y <= 0 and $this->x <= $this->r && $this->y >= -$this->r);

    }

    function checkTriange()
    {
        return ($this->x <= 0 && $this->y >= 0 && $this->y <= $this->r / 2 && $this->x >= -$this->r / 2 and abs($this->x) + $this->y <= $this->r / 2);
    }

    function checkCircle()
    {
        return ($this->x ** 2 + $this->y ** 2 <= $this->r ** 2);
    }

    function checkPoint()
    {
        return $this->checkSquare() || $this->checkTriange() || $this->checkCircle();
    }


}
@session_start();
if (!isset($_SESSION["results"])) {
    $_SESSION["results"] = array();
}

$x = $_POST['x'];
$y = $_POST['y'];
$r = $_POST['r'];

$time_zone_offset = $_POST['time_zone_offset'];
$validator = new Coordinatesvalidator($x, $y, $r);
if ($validator->checkData()) {
    $hitPoint = new HitPoint($x, $y, $r);
    $flag = $hitPoint->checkPoint() ? "TRUE" : "FALSE";
    $time = date('H:i:s', time());
    $start_time = round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 8);
    $newResult = array(
        "x" => $x,
        "y" => $y,
        "r" => $r,
        "coordsStatus" => $flag,
        "currentTime" => $start_time,
        "benchmarkTime" => $time
    );
    array_push($_SESSION["results"], $newResult);
    foreach (array_reverse($_SESSION["results"]) as $tableRow) {
        echo "<tr>";
        echo "<td>" . $tableRow["x"] . "</td>";
        echo "<td>" . $tableRow["y"] . "</td>";
        echo "<td>" . $tableRow["r"] . "</td>";
        echo "<td>" . $tableRow["coordsStatus"] . "</td>";
        echo "<td>" . $tableRow["currentTime"] . "</td>";
        echo "<td>" . $tableRow["benchmarkTime"] . "</td>";
        echo "</tr>";
    }
}
