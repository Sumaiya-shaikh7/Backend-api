<?php
require_once "helpers/response.php";

$data = json_decode(file_get_contents("data/performance.json"), true);

sendJSON(true, "Performance data fetched successfully", $data);
