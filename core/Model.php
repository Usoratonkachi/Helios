<?php
class Model {
    protected $dbh;

    public function __construct() {
        $this->dbh = $GLOBALS['dbh'];
    }
}
?>
