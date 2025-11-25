<?php

include_once("models/DB.php");
include_once("models/TabelPembalap.php");
include_once("models/TabelSirkuit.php");

include_once("views/ViewPembalap.php");
include_once("views/ViewSirkuit.php");

include_once("presenters/PresenterPembalap.php");
include_once("presenters/PresenterSirkuit.php");

// Koneksi DB
$dbHost = 'localhost';
$dbName = 'mvp_db';
$dbUser = 'root';
$dbPass = ''; // Sesuaikan password database Anda

// Routing sederhana berdasarkan parameter 'nav'
$nav = $_GET['nav'] ?? 'pembalap';

// =======================
// MODULE: PEMBALAP
// =======================
if ($nav == 'pembalap') {
    $tabel = new TabelPembalap($dbHost, $dbName, $dbUser, $dbPass);
    $view = new ViewPembalap();
    $presenter = new PresenterPembalap($tabel, $view);

    // Handle Actions (POST)
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action == 'add') {
            $presenter->tambahPembalap($_POST['nama'], $_POST['tim'], $_POST['negara'], $_POST['poinMusim'], $_POST['jumlahMenang']);
        } elseif ($action == 'edit') {
            $presenter->ubahPembalap($_POST['id'], $_POST['nama'], $_POST['tim'], $_POST['negara'], $_POST['poinMusim'], $_POST['jumlahMenang']);
        } elseif ($action == 'delete') {
            $presenter->hapusPembalap($_POST['id']);
        }
        header("Location: index.php"); // Refresh ke list
        exit();
    }

    // Handle Views (GET)
    $screen = $_GET['screen'] ?? 'list';
    
    // Tambahkan navigasi menu di atas output
    echo '<div style="max-width:980px; margin:20px auto; padding:0 18px;">
            <a href="index.php?nav=pembalap" style="font-weight:bold; margin-right:15px; text-decoration:none; color:blue;">Data Pembalap</a>
            <a href="index.php?nav=sirkuit" style="margin-right:15px; text-decoration:none; color:gray;">Data Sirkuit</a>
          </div>';

    if ($screen == 'add') {
        echo $presenter->tampilkanFormPembalap();
    } elseif ($screen == 'edit' && isset($_GET['id'])) {
        echo $presenter->tampilkanFormPembalap($_GET['id']);
    } else {
        echo $presenter->tampilkanPembalap();
    }
}

// =======================
// MODULE: SIRKUIT
// =======================
elseif ($nav == 'sirkuit') {
    $tabel = new TabelSirkuit($dbHost, $dbName, $dbUser, $dbPass);
    $view = new ViewSirkuit();
    $presenter = new PresenterSirkuit($tabel, $view);

    // Handle Actions (POST)
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action == 'add') {
            $presenter->prosesTambah($_POST);
        } elseif ($action == 'edit') {
            $presenter->prosesUbah($_POST);
        } elseif ($action == 'delete') {
            $presenter->prosesHapus($_POST['id']);
        }
        header("Location: index.php?nav=sirkuit");
        exit();
    }

    // Handle Views (GET)
    $screen = $_GET['screen'] ?? 'list';

    // Tambahkan navigasi menu
    echo '<div style="max-width:980px; margin:20px auto; padding:0 18px;">
            <a href="index.php?nav=pembalap" style="margin-right:15px; text-decoration:none; color:gray;">Data Pembalap</a>
            <a href="index.php?nav=sirkuit" style="font-weight:bold; margin-right:15px; text-decoration:none; color:blue;">Data Sirkuit</a>
          </div>';

    if ($screen == 'add') {
        echo $presenter->tampilkanForm();
    } elseif ($screen == 'edit' && isset($_GET['id'])) {
        echo $presenter->tampilkanForm($_GET['id']);
    } else {
        echo $presenter->tampilkanSirkuit();
    }
}
?>