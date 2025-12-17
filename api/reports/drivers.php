<?php
require_once "helpers/response.php";

$data = json_decode(file_get_contents("data/drivers.json"), true);

sendJSON(true, "Driver activity fetched successfully", $data);
