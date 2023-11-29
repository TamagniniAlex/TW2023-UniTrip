<?php
class Controller
{
    public $model;
    public function __construct( $model = new Model()){
        $this->model = $model;
    }
}
?>