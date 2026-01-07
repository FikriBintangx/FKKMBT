<div class="container py-4">
    <!-- Header Section -->
    <div class="text-center mb-5 mt-3 rounded-4 p-4 text-white shadow-lg position-relative overflow-hidden" style="background: linear-gradient(135deg, #1e5631 0%, #0d3820 100%);">
        <div class="position-absolute top-0 end-0 p-3 opacity-10">
            <i class="bi bi-people-fill display-1"></i>
        </div>
        <span class="badge bg-white text-success rounded-pill mb-2 px-3 fw-bold">DATABASE WARGA</span>
        <h2 class="fw-bold display-6 mb-2">Direktori Warga</h2>
        <p class="mb-0 opacity-75" style="max-width: 600px; margin: 0 auto;">
            Cari lokasi blok dan informasi warga untuk keperluan silaturahmi.
        </p>
    </div>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-12">
            <form action="" method="GET" class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-2 d-flex align-items-center">
                    <input type="hidden" name="blok" value="<?= $this->input->get('blok') ?>">
                    <input type="text" name="search" class="form-control border-0 shadow-none ps-3" placeholder="Ketik nama warga atau nomor rumah..." value="<?= $this->input->get('search') ?>">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold" style="background: linear-gradient(135deg, #1e5631 0%, #0d3820 100%); border: none;">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <!-- House Icon Grid (Filter Blok) -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
        <div class="text-center mb-4">
            <h6 class="fw-bold"><i class="bi bi-houses-fill me-2 text-success"></i>Pilih Blok (Rumah)</h6>
            <p class="text-muted small">Klik pada Blok Utama (Huruf) untuk melihat Unit (Angka)</p>
        </div>
        
        <?php 
           $blocks = range('A', 'T');
           $activeMainBlock = !empty($selected_blok) ? substr($selected_blok, 0, 1) : '';
        ?>
        
        <!-- Main Block Buttons (Letters) -->
        <div class="d-flex flex-wrap justify-content-center gap-2 mb-3">
             <a href="<?= base_url('warga') ?>" class="btn btn-sm rounded-pill fw-bold border px-3 <?= empty($selected_blok) ? 'btn-success text-white' : 'btn-light text-muted' ?>">
                Semua
            </a>
            <?php foreach($blocks as $letter): ?>
                <button type="button" class="btn btn-sm rounded-pill fw-bold px-3 border main-block-btn <?= ($activeMainBlock == $letter) ? 'btn-success text-white' : 'btn-light text-dark' ?>" 
                        onclick="toggleSubBlock('<?= $letter ?>')">
                    Blok <?= $letter ?>
                </button>
            <?php endforeach; ?>
        </div>
        
        <!-- Sub Block Area (Hidden by default, shown via JS) -->
        <div id="subBlockContainer" class="bg-light rounded-4 p-3 mt-3 <?= empty($activeMainBlock) ? 'd-none' : '' ?>">
            <div class="text-center mb-2">
                <span class="badge bg-white text-dark shadow-sm border fw-bold" id="currentBlockLabel">Unit Blok <?= $activeMainBlock ?></span>
            </div>
            <div class="row g-3 justify-content-center" id="houseGrid">
                 <!-- Populated by JS -->
                 <?php if(!empty($activeMainBlock)): ?>
                    <?php for($i=1; $i<=5; $i++): 
                        $blokCode = $activeMainBlock . $i;
                        $isActive = ($selected_blok == $blokCode);
                    ?>
                    <div class="col-4 col-sm-3 col-md-2 p-1 fade-in">
                        <a href="?blok=<?= $blokCode ?>" class="btn w-100 p-0 border-0 position-relative house-btn <?= $isActive ? 'active' : '' ?>">
                             <div class="house-icon shadow-sm">
                                 <div class="roof"></div>
                                 <div class="body d-flex flex-column align-items-center justify-content-center">
                                     <span class="fw-bold fs-5 house-text"><?= $blokCode ?></span>
                                 </div>
                             </div>
                        </a>
                    </div>
                    <?php endfor; ?>
                 <?php endif; ?>
            </div>
        </div>

    </div>

    <!-- Results List -->
    <div class="d-flex flex-column gap-3">
        <?php if(!empty($warga_list)): ?>
            <?php foreach($warga_list as $row): ?>
            <div class="card border-0 shadow-sm rounded-4 w-100 hover-scale cursor-pointer">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="bg-success text-white rounded-3 d-flex flex-column align-items-center justify-content-center p-2 shadow-sm" style="width: 50px; height: 50px;">
                        <small style="font-size: 8px; font-weight: 700;">BLOK</small>
                        <span class="fs-4 fw-bold lh-1"><?= $row['blok'] ?></span>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold text-dark mb-1"><?= $row['nama_lengkap'] ?></h6>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-light text-dark border rounded-pill" style="font-size: 10px;">No. <?= $row['no_rumah'] ?></span>
                            <?php if(!empty($row['status_huni'])): ?>
                                <span class="badge bg-success-subtle text-success rounded-pill" style="font-size: 10px;"><?= $row['status_huni'] ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <a href="https://wa.me/<?= $row['no_hp'] ?>" class="btn btn-success rounded-circle shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-5">
                <div class="bg-light rounded-circle d-inline-flex p-4 mb-3 text-muted">
                    <i class="bi bi-search fs-1 opacity-50"></i>
                </div>
                <h6 class="fw-bold text-dark">Warga Tidak Ditemukan</h6>
                <p class="text-muted small">Pilih Blok atau gunakan pencarian.</p>
            </div>
        <?php endif; ?>
    </div>

    <style>
        .hover-scale { transition: transform 0.2s; }
        .hover-scale:hover { transform: scale(1.02); }
        .house-btn { text-decoration: none; }
        .house-icon { display: flex; flex-direction: column; align-items: center; transition: transform 0.2s; }
        .house-btn:hover .house-icon { transform: translateY(-5px); }
        .roof { width: 0; height: 0; border-left: 25px solid transparent; border-right: 25px solid transparent; border-bottom: 20px solid #cbd5e1; position: relative; z-index: 1; }
        .body { width: 40px; height: 35px; background-color: #f1f5f9; border-bottom-left-radius: 4px; border-bottom-right-radius: 4px; color: #64748b; }
        .house-btn.active .roof { border-bottom-color: #15803d; }
        .house-btn.active .body { background-color: #dcfce7; color: #15803d; font-weight: 800; }
        .fade-in { animation: fadeIn 0.5s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <script>
    function toggleSubBlock(letter) {
        const container = document.getElementById('subBlockContainer');
        const grid = document.getElementById('houseGrid');
        const label = document.getElementById('currentBlockLabel');
        const btns = document.querySelectorAll('.main-block-btn');
        
        // Reset buttons style
        btns.forEach(btn => {
            btn.classList.remove('btn-success', 'text-white');
            btn.classList.add('btn-light', 'text-dark');
        });
        
        // Highlight active button (this logic is simple for Click events, but might need adjustment to find the specific button element reference if not passed)
        // For simplicity, we just rely on visual update. In a real app we'd pass 'this'.
        
        event.target.classList.remove('btn-light', 'text-dark');
        event.target.classList.add('btn-success', 'text-white');

        container.classList.remove('d-none');
        label.innerText = 'Unit Blok ' + letter;
        grid.innerHTML = ''; // Clear existing

        for(let i=1; i<=5; i++) {
            let code = letter + i;
            // Note: In real logic, we'd check if this matches current URL param, but for client-side toggling we just render links.
            let isActive = '<?= $selected_blok ?? '' ?>' === code;
            let activeClassRoof = isActive ? 'border-bottom-color: #15803d;' : ''; 
            
            // We use JS template literal for HTML
            let html = `
                <div class="col-4 col-sm-3 col-md-2 p-1 fade-in">
                    <a href="?blok=${code}" class="btn w-100 p-0 border-0 position-relative house-btn ${isActive ? 'active' : ''}">
                         <div class="house-icon shadow-sm">
                             <div class="roof"></div>
                             <div class="body d-flex flex-column align-items-center justify-content-center">
                                 <span class="fw-bold fs-5 house-text">${code}</span>
                             </div>
                         </div>
                    </a>
                </div>
            `;
            grid.innerHTML += html;
        }
    }
    </script>
</div>
