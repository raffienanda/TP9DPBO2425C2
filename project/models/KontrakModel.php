<?php

interface KontrakModel
{
    public function getAllPembalap(): array;
    public function getPembalapById($id): ?array;

    // method crud pembalap
    public function addPembalap($nama, $tim, $negara, $poinMusim, $jumlahMenang): void;
    public function updatePembalap($id, $nama, $tim, $negara, $poinMusim, $jumlahMenang): void;
    public function deletePembalap($id): void;
}

?>