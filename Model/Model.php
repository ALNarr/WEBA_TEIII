<?php

class Model {

    private $db;

    public function __construct(bool $withErrors = false) {
        $this->db = new PDO("mysql:host=127.0.0.1;dbname=weba-te03-2025;charset=UTF8", 'root', '');
        if ($withErrors) {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    } 

    // TODO
}
?>