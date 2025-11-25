<?php
class Sirkuit {
    private $id, $nama, $negara, $panjang, $tikungan;

    public function __construct($id, $nama, $negara, $panjang, $tikungan){
        $this->id = $id; $this->nama = $nama; $this->negara = $negara;
        $this->panjang = $panjang; $this->tikungan = $tikungan;
    }
    // Getters
    public function getId(){ return $this->id; }
    public function getNama(){ return $this->nama; }
    public function getNegara(){ return $this->negara; }
    public function getPanjang(){ return $this->panjang; }
    public function getTikungan(){ return $this->tikungan; }
}
?>