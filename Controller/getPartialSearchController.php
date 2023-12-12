<?php
require_once("../model/searchModel.php");

$search = new SearchModel();

if (isset($_GET["text"]) && !empty($_GET["text"])) {
    echo json_encode($search->getPartialSearch($_GET["text"]));
} else {
    echo json_encode("error");
}

?>