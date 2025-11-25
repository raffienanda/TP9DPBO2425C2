<?php
include_once("KontrakViewSirkuit.php");
include_once("models/Sirkuit.php");

class ViewSirkuit implements KontrakViewSirkuit {
    public function tampilSirkuit($listSirkuit): string {
        $tbody = '';
        $no = 1;
        foreach($listSirkuit as $s){
            $tbody .= '<tr>
                <td class="col-id">'.$no.'</td>
                <td>'.htmlspecialchars($s->getNama()).'</td>
                <td>'.htmlspecialchars($s->getNegara()).'</td>
                <td>'.htmlspecialchars($s->getPanjang()).' km</td>
                <td>'.htmlspecialchars($s->getTikungan()).'</td>
                <td class="col-actions">
                    <a href="index.php?nav=sirkuit&screen=edit&id='.$s->getId().'" class="btn btn-edit">Edit</a>
                    <button data-id="'.$s->getId().'" class="btn btn-delete">Hapus</button>
                </td>
            </tr>';
            $no++;
        }
        
        // Menggunakan template skin.html yang sama, tapi kita ubah header tabelnya via replace
        $template = file_get_contents(__DIR__ . '/../template/skin.html');
        
        // Ubah Judul
        $template = str_replace('Daftar Pembalap', 'Daftar Sirkuit', $template);
        $template = str_replace('Pembalap — Daftar', 'Sirkuit — Daftar', $template);
        $template = str_replace('+ Tambah Pembalap', '+ Tambah Sirkuit', $template);
        $template = str_replace('href="index.php?screen=add"', 'href="index.php?nav=sirkuit&screen=add"', $template);
        
        // Ubah Header Tabel
        $headerBaru = '<th>Nama Sirkuit</th><th>Negara</th><th>Panjang (km)</th><th>Tikungan</th>';
        $headerLama = '<th>Nama</th><th>Tim</th><th>Negara</th><th>Poin Musim</th><th>Jumlah Menang</th>';
        $template = str_replace($headerLama, $headerBaru, $template);

        // Inject Rows
        $template = str_replace('', $tbody, $template);
        $template = str_replace('Total:', 'Total: ' . count($listSirkuit), $template);

        // Ubah Script delete agar tetap di nav=sirkuit
        $scriptLama = "actionInput.value = 'delete';";
        $scriptBaru = "actionInput.value = 'delete'; \n var navInput = document.createElement('input'); navInput.type='hidden'; navInput.name='nav'; navInput.value='sirkuit'; form.appendChild(navInput);";
        $template = str_replace($scriptLama, $scriptBaru, $template);

        return $template;
    }

    public function tampilFormSirkuit($data = null): string {
        // Kita buat HTML form sirkuit langsung di sini atau replace form.html
        // Agar mudah, kita replace form.html
        $template = file_get_contents(__DIR__ . '/../template/form.html');
        
        $template = str_replace('Form Pembalap', 'Form Sirkuit', $template);
        $template = str_replace('action="index.php"', 'action="index.php?nav=sirkuit"', $template);
        
        // Replace Fields
        // Kita hapus field lama dan ganti dengan field sirkuit
        $fields = '
        <div><label>Nama Sirkuit</label><input name="nama" type="text" required value="'.($data['nama']??'').'"></div>
        <div><label>Negara</label><input name="negara" type="text" required value="'.($data['negara']??'').'"></div>
        <div><label>Panjang (km)</label><input name="panjang" type="number" step="0.01" value="'.($data['panjang_km']??'').'"></div>
        <div><label>Jumlah Tikungan</label><input name="tikungan" type="number" value="'.($data['jumlah_tikungan']??'').'"></div>
        ';
        
        // Trik regex sederhana untuk menghapus form lama dan memasukkan yang baru
        // Atau lebih aman kita replace konten spesifik jika struktur form html konsisten
        // Untuk amannya, saya replace label-label spesifik dari form.html user
        
        $formContent = '
        <input type="hidden" name="nav" value="sirkuit">
        <input type="hidden" name="action" value="'.($data ? 'edit' : 'add').'">
        <input type="hidden" name="id" value="'.($data['id']??'').'">
        '.$fields.'
        <div class="full actions">
            <a href="index.php?nav=sirkuit" class="btn btn-muted">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        ';

        // Ambil isi body card dan ganti dengan form kita
        // Karena replace ribet, saya return string HTML full simple saja
        // Tapi agar style terjaga, kita inject ke <div class="card">
        
        $cleanTemplate = preg_replace('/<form.*<\/form>/s', '<form method="post" action="index.php">'.$formContent.'</form>', $template);
        return $cleanTemplate;
    }
}
?>