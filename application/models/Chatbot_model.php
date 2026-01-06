<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chatbot_model extends CI_Model {
    
    private $knowledge_base = [];

    public function __construct() {
        // parent::__construct(); // Removed - causes error on production
        $this->_init_knowledge();
        $this->_check_table();
    }

    private function _check_table() {
        $sql = "CREATE TABLE IF NOT EXISTS chatbot_history (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            question TEXT NOT NULL,
            answer TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->db->query($sql);
    }

    private function _init_knowledge() {
        $this->knowledge_base = [
            // Jadwal & Waktu
            'sampah|diangkut|ambil sampah|jadwal sampah' => 'Jadwal pengangkutan sampah:\n🗑️ Senin, Rabu, Jumat: Pukul 06.00 - 08.00 WIB\n📍 Taruh di depan pagar masing-masing rumah',
            
            // Iuran
            'iuran|tagihan|bayar|pembayaran|biaya' => 'Informasi Iuran Bulanan:\n💰 Iuran Satpam: Rp 50.000/bulan\n💰 Iuran Kebersihan: Rp 25.000/bulan\n\nBayar melalui menu "Iuran Saya" di dashboard atau transfer ke Rek BCA 1234567890 a/n FKKMBT',
            
            // Kontak Penting
            'nomor|kontak|telepon|satpam|security|ketua|pengurus' => 'Kontak Penting:\n📞 Satpam 24 Jam: 0812-3456-7890\n📞 Ketua RT: 0813-4567-8901\n📞 Sekretaris: 0814-5678-9012\n🚨 Darurat: Tekan tombol SOS di dashboard!',
            
            // Surat
            'surat|domisili|pengantar|administrasi' => 'Cara Buat Surat:\n1. Klik menu "E-Surat" di dashboard\n2. Pilih jenis surat yang dibutuhkan\n3. Isi keperluan surat\n4. Kirim permohonan\n5. Tunggu approval admin (max 2x24 jam)\n\nTersedia: Surat Domisili, Pengantar Nikah, Ket. Usaha, dll.',
            
            // Kegiatan
            'kegiatan|acara|agenda|event' => 'Lihat jadwal kegiatan terbaru di:\n📅 Menu "Kegiatan" di dashboard\n\nKegiatan rutin:\n- Senam Minggu: Minggu 06.00 WIB\n- Arisan RT: Minggu pertama tiap bulan\n- Kerja Bakti: Minggu terakhir tiap bulan',
            
            // Lapak
            'jual|beli|lapak|marketplace|produk' => 'Mau jualan atau belanja dari tetangga?\n🛒 Kunjungi menu "Lapak Warga"\n- Marketplace khusus warga\n- Chat langsung via WhatsApp\n- Murah & terpercaya!',
            
            // Pengaduan
            'lapor|complaint|masalah|rusak|aduan' => 'Ada masalah di lingkungan?\n📢 Gunakan menu "Lapor Pak!"\n- Upload foto bukti\n- Admin akan follow up\n- Cek status laporan real-time',
            
            // Parkir & Kendaraan
            'parkir|mobil|motor|kendaraan' => 'Aturan Parkir:\n🚗 Parkir di dalam kavling masing-masing\n🚫 Dilarang parkir di jalan utama\n⏰ Jika tamu parkir di luar, max 2 jam\n\nUntuk tamu menginap, lapor ke satpam',
            
            // Keamanan
            'aman|maling|cctv|ronda' => 'Keamanan Kompleks:\n👮 Satpam 24 jam di pos utama\n📹 CCTV aktif 12 titik\n🚨 Tombol SOS di dashboard untuk darurat\n🔦 Ronda malam: 22.00 - 04.00 WIB',
            
            // Default
            'default' => 'Maaf, saya belum paham pertanyaan Anda 😅\n\nCoba tanyakan:\n• Jadwal sampah\n• Info iuran\n• Nomor penting\n• Cara buat surat\n• Info kegiatan\n\nAtau hubungi admin untuk bantuan lebih lanjut!'
        ];
    }

    public function get_answer($question) {
        $question = strtolower($question);
        
        foreach ($this->knowledge_base as $pattern => $answer) {
            if ($pattern == 'default') continue;
            
            $keywords = explode('|', $pattern);
            foreach ($keywords as $keyword) {
                if (strpos($question, trim($keyword)) !== false) {
                    return $answer;
                }
            }
        }
        
        return $this->knowledge_base['default'];
    }

    public function save_history($user_id, $question, $answer) {
        $data = [
            'user_id' => $user_id,
            'question' => $question,
            'answer' => $answer
        ];
        return $this->db->insert('chatbot_history', $data);
    }

    public function get_history($user_id, $limit = 10) {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('chatbot_history')->result_array();
    }
}
