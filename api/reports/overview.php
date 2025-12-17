<?php
require_once "helpers/response.php";

$data = json_decode(file_get_contents("data/overview.json"), true);

sendJSON(true, "Overview data fetched successfully", $data);
