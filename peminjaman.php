<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Buku.class.php");
include("includes/Peminjaman.class.php");
include("includes/Member.class.php");

$buku = new Buku($db_host, $db_user, $db_pass, $db_name);
$buku->open();
$buku->getBuku();

$member = new Member($db_host, $db_user, $db_pass, $db_name);
$member->open();
$member->getMember();

$peminjaman = new Peminjaman($db_host, $db_user, $db_pass, $db_name);
$peminjaman->open();
$peminjaman->getPeminjaman();

$status = false;
$alert = null;

if (isset($_POST['add'])) {
    echo "Getin";
    //memanggil add
    $peminjaman->add($_POST);
    header("location:peminjaman.php");
}

if (!empty($_GET['id_delete'])) {
    //memanggil add
    $id = $_GET['id_delete'];

    $peminjaman->delete($id);
    header("location:peminjaman.php");
}

if (!empty($_GET['id_return'])) {
    //memanggil add
    $id = $_GET['id_return'];

    $peminjaman->returnPeminjaman($id);
    header("location:peminjaman.php");
}

$data = null;
$dataBuku = null;
$dataMember = null;
$no = 1;

while (list($id, $judul) = $buku->getResult()) {
    $dataBuku .= "<option value='".$id."'>".$judul."</option>
                ";
}

while (list($nim, $nama) = $member->getResult()) {
    $dataMember .= "<option value='".$nim."'>".$nama."</option>
                ";
}

while (list($id, $tanggal_pinjam, $status, $id_buku, $nim) = $peminjaman->getResult()) {
    $member->getMember($nim);
    list($result_nim, $result_nama) = $member->getResult();
    $buku->getBuku($id_buku);
    list($result_id, $result_judul) = $buku->getResult();
    if ($status == "dikembalikan") {
        $data .= "<tr>
            <td>" . $no++ . "</td>
            <td>" . $result_nama . "</td>
            <td>" . $result_judul . "</td>
            <td>" . $tanggal_pinjam . "</td>
            <td>" . "Dikembalikan" . "</td>
            <td>
            <a href='peminjaman.php?id_delete=" . $id .  "' class='btn btn-danger' '>Hapus</a>
            </td>
            </tr>";
    }
    else {
            $data .= "<tr>
            <td>" . $no++ . "</td>
            <td>" . $result_nama . "</td>
            <td>" . $result_judul . "</td>
            <td>" . $tanggal_pinjam . "</td>
            <td>" . "Dalam Peminjaman" . "</td>
            <td>
            <a href='peminjaman.php?id_return=" . $id .  "' class='btn btn-success' '>Kembalikan</a>
            </td>
            </tr>";
    }
}



$member->close();
$buku->close();
$tpl = new Template("templates/peminjaman.html");
$tpl->replace("OPTION_PEMINJAM", $dataMember);
$tpl->replace("OPTION_BUKU", $dataBuku);
$tpl->replace("DATA_TABEL", $data);
$tpl->write();
