<?php
class Setup_forum extends CI_Controller {
    public function index() {
        $this->load->database();
        
        $sql1 = "CREATE TABLE IF NOT EXISTS `forum` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `warga_id` int(11) NOT NULL,
            `konten` text NOT NULL,
            `likes` int(11) DEFAULT 0,
            `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        
        $sql2 = "CREATE TABLE IF NOT EXISTS `forum_komentar` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `forum_id` int(11) NOT NULL,
            `warga_id` int(11) NOT NULL,
            `komentar` text NOT NULL,
            `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        if($this->db->query($sql1) && $this->db->query($sql2)) {
            echo "Tabel Forum berhasil dibuat!";
        } else {
            echo "Gagal: " . $this->db->error();
        }
    }
}
