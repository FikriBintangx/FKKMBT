<div class="container py-5">
    <div class="text-center mb-5">
        <h6 class="text-primary fw-bold text-uppercase">Galeri & Agenda</h6>
        <h1 class="fw-bold">Kegiatan Warga</h1>
        <p class="text-muted col-lg-8 mx-auto">Dokumentasi kegiatan rutin dan agenda acara mendatang di lingkungan Bukit Tiara.</p>
    </div>

    <!-- Calendar Section -->
    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-white border-bottom-0 p-4 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold"><i class="bi bi-calendar-week me-2 text-primary"></i>Kalender Kegiatan</h4>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-light text-dark btn-sm"><i class="bi bi-chevron-left"></i></button>
                        <span class="fw-bold px-3 py-1 bg-light rounded">Agustus 2025</span>
                        <button class="btn btn-outline-light text-dark btn-sm"><i class="bi bi-chevron-right"></i></button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <!-- Calendar Grid -->
                    <div class="calendar-grid">
                        <!-- Days Header -->
                        <div class="calendar-header bg-light fw-bold text-center py-3 text-secondary">Minggu</div>
                        <div class="calendar-header bg-light fw-bold text-center py-3 text-secondary">Senin</div>
                        <div class="calendar-header bg-light fw-bold text-center py-3 text-secondary">Selasa</div>
                        <div class="calendar-header bg-light fw-bold text-center py-3 text-secondary">Rabu</div>
                        <div class="calendar-header bg-light fw-bold text-center py-3 text-secondary">Kamis</div>
                        <div class="calendar-header bg-light fw-bold text-center py-3 text-secondary">Jumat</div>
                        <div class="calendar-header bg-light fw-bold text-center py-3 text-secondary">Sabtu</div>

                        <!-- Calendar Days (Logic would be dynamic in real app, static for demo) -->
                        
                        <!-- Empty Previous Month Days -->
                        <div class="calendar-day text-muted bg-light bg-opacity-25">27</div>
                        <div class="calendar-day text-muted bg-light bg-opacity-25">28</div>
                        <div class="calendar-day text-muted bg-light bg-opacity-25">29</div>
                        <div class="calendar-day text-muted bg-light bg-opacity-25">30</div>
                        <div class="calendar-day text-muted bg-light bg-opacity-25">31</div>
                        
                        <!-- Aug 1 -->
                        <div class="calendar-day">1</div>
                        <!-- Aug 2 (Today Demo) -->
                        <div class="calendar-day active-today">
                            2
                            <span class="badge bg-primary mt-1 d-block text-truncate" style="font-size: 0.65rem;">Rapat RT</span>
                        </div>
                         <div class="calendar-day">3 <span class="badge bg-success mt-1 d-block text-truncate" style="font-size: 0.65rem;">Senam</span></div>
                        <div class="calendar-day">4</div>
                        <div class="calendar-day">5</div>
                        <div class="calendar-day">6</div>
                        <div class="calendar-day">7</div>
                        <div class="calendar-day">8</div>
                        <div class="calendar-day">9</div>
                        <!-- Aug 10 -->
                        <div class="calendar-day">
                            10
                             <span class="badge bg-success mt-1 d-block text-truncate" style="font-size: 0.65rem;">Posyandu</span>
                        </div>
                        <div class="calendar-day">11</div>
                        <div class="calendar-day">12</div>
                        <div class="calendar-day">13</div>
                        <div class="calendar-day">14</div>
                        <div class="calendar-day">15</div>
                        <div class="calendar-day">16</div>
                        <!-- Aug 17 (Event) -->
                        <div class="calendar-day event-date">
                            17
                            <span class="badge bg-danger mt-1 d-block text-truncate" style="font-size: 0.65rem;">HUT RI ke-80</span>
                        </div>
                        <div class="calendar-day">18</div>
                        <div class="calendar-day">19</div>
                        <div class="calendar-day">20</div>
                        <div class="calendar-day">21</div>
                        <div class="calendar-day">22</div>
                        <div class="calendar-day">23</div>
                        <div class="calendar-day">24 <span class="badge bg-success mt-1 d-block text-truncate" style="font-size: 0.65rem;">Senam</span></div>
                        <div class="calendar-day">25</div>
                        <div class="calendar-day">26</div>
                        <div class="calendar-day">27</div>
                        <div class="calendar-day">28</div>
                        <div class="calendar-day">29</div>
                        <div class="calendar-day">30</div>
                        <div class="calendar-day">31</div>
                        
                        <!-- Empty Next Month Days -->
                         <div class="calendar-day text-muted bg-light bg-opacity-25">1</div>
                         <div class="calendar-day text-muted bg-light bg-opacity-25">2</div>
                         <div class="calendar-day text-muted bg-light bg-opacity-25">3</div>
                         <div class="calendar-day text-muted bg-light bg-opacity-25">4</div>
                         <div class="calendar-day text-muted bg-light bg-opacity-25">5</div>
                         <div class="calendar-day text-muted bg-light bg-opacity-25">6</div>

                    </div>
                </div>
            </div>
            
            <style>
                .calendar-grid {
                    display: grid;
                    grid-template-columns: repeat(7, 1fr);
                    border-top: 1px solid #dee2e6;
                    border-left: 1px solid #dee2e6;
                }
                .calendar-header {
                    border-right: 1px solid #dee2e6;
                    border-bottom: 1px solid #dee2e6;
                    font-size: 0.9rem;
                }
                .calendar-day {
                    min-height: 120px;
                    background-color: #fff;
                    border-right: 1px solid #dee2e6;
                    border-bottom: 1px solid #dee2e6;
                    padding: 10px;
                    font-weight: 500;
                    color: #495057;
                    transition: background-color 0.2s;
                }
                .calendar-day:hover {
                    background-color: #f8f9fa;
                }
                .active-today {
                    background-color: #e8f4fd !important; /* Soft Blue */
                    color: #0d6efd;
                    font-weight: bold;
                }
                .event-date {
                    background-color: #fdf2e9; /* Soft Orange */
                }
                @media (max-width: 768px) {
                    .calendar-day {
                        min-height: 80px;
                        font-size: 0.8rem;
                    }
                    .calendar-header {
                        font-size: 0.7rem;
                        padding: 5px 0;
                    }
                }
            </style>
        </div>
    </div>

    <!-- Event List (Secondary) -->
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-header bg-white p-3">
             <h6 class="mb-0 fw-bold">Detail Agenda</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Tanggal</th>
                        <th>Kegiatan</th>
                        <th>Lokasi</th>
                        <th>Waktu</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-4 fw-bold text-primary">17 Agustus 2025</td>
                        <td>Pesta Rakyat HUT RI ke-80</td>
                        <td>Lapangan Utama</td>
                        <td>08:00 - Selesai</td>
                        <td><span class="badge bg-warning text-dark">Segera</span></td>
                    </tr>
                    <tr>
                        <td class="ps-4 fw-bold text-primary">Setiap Minggu</td>
                        <td>Senam Sehat Bersama</td>
                        <td>Halaman Balai Warga</td>
                        <td>06:30 - 08:00</td>
                        <td><span class="badge bg-success">Rutin</span></td>
                    </tr>
                    <tr>
                        <td class="ps-4 fw-bold text-primary">Setiap Bulan (Tgl 10)</td>
                        <td>Posyandu Balita & Lansia</td>
                        <td>Posyandu Mawar</td>
                        <td>09:00 - 12:00</td>
                        <td><span class="badge bg-success">Rutin</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Gallery Grid -->
    <h4 class="mb-4">Galeri Kegiatan</h4>
    <div class="row g-4">
        <!-- Placeholder Images -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="height: 200px;">
                    <i class="bi bi-image fs-1"></i>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Kerja Bakti Masal</h5>
                    <p class="card-text text-muted small">Membersihkan saluran air antisipasi banjir.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="height: 200px;">
                    <i class="bi bi-image fs-1"></i>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Malam Tirakatan</h5>
                    <p class="card-text text-muted small">Doa bersama menyambut hari kemerdekaan.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="height: 200px;">
                    <i class="bi bi-image fs-1"></i>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Santunan Anak Yatim</h5>
                    <p class="card-text text-muted small">Berbagi kebahagiaan di bulan Ramadhan.</p>
                </div>
            </div>
        </div>
    </div>
</div>
