<?php
require_once "helpers/response.php";

$data = json_decode(file_get_contents("data/revenue.json"), true);

sendJSON(true, "Revenue analytics fetched successfully", $data);
