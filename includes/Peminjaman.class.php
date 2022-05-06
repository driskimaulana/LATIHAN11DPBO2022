<?php

class Peminjaman extends DB
{
    function getPeminjaman($nim = "")
    {
        if ($nim == "") {
            $query = "SELECT * FROM peminjaman";
            return $this->execute($query);
        }
        $query = "SELECT * FROM peminjaman WHERE nim='$nim'";
        return $this->execute($query);
    }

    function add($data)
    {
        $tanggal_pinjam = $data['tanggal_pinjam'];
        $status = "dipinjam";
        $id_buku = $data['id_buku'];
        $nim = $data['nim'];

        $query = "insert into peminjaman(tanggal_pinjam, status, id_buku, nim) values ('$tanggal_pinjam', '$status', '$id_buku', '$nim')";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {

        $query = "delete FROM peminjaman WHERE id_pinjaman = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function searchPeminjam($keyword){
        
    }

    function returnPeminjaman($id){
        $query = "UPDATE peminjaman SET status='dikembalikan' WHERE id_pinjaman = $id";
        // Mengeksekusi query
        return $this->execute($query);
    }

}
