<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Tanya AI - FKKMBT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css?v='.time()) ?>">
    <style>
        body {
            background-color: #e2e8f0;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%2394a3b8' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        .chat-app-bar {
            background: var(--primary-gradient);
            padding: 15px 20px;
            color: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            position: relative;
            z-index: 10;
        }
        .chat-area {
            flex: 1;
            overflow-y: auto;
            padding: 20px 15px;
            padding-bottom: 200px; /* Space for input area */
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .message-bubble {
            max-width: 80%;
            padding: 12px 16px;
            border-radius: 16px;
            position: relative;
            font-size: 14px;
            line-height: 1.5;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .msg-bot {
            align-self: flex-start;
            background: white;
            color: #1e293b;
            border-bottom-left-radius: 4px;
        }
        .msg-user {
            align-self: flex-end;
            background: var(--primary-color);
            color: white;
            border-bottom-right-radius: 4px;
        }
        .msg-time {
            font-size: 10px;
            margin-top: 4px;
            opacity: 0.7;
            text-align: right;
        }
        .msg-bot .msg-time { text-align: left; }
        
        .c-footer {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            background: #f8fafc;
            padding: 10px;
            border-top: 1px solid #e2e8f0;
            z-index: 100;
        }
        .quick-actions {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 10px;
            scrollbar-width: none;
            margin-bottom: 5px;
        }
        .quick-actions::-webkit-scrollbar { display: none; }
        .q-chip {
            white-space: nowrap;
            padding: 8px 16px;
            background: white;
            border: 1px solid #cbd5e1;
            border-radius: 50px;
            font-size: 12px;
            color: #475569;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }
        .q-chip:active { background: #e2e8f0; }

        .typing-pill {
            display: none;
            padding: 8px 16px;
            background: white;
            border-radius: 50px;
            align-self: flex-start;
            margin-bottom: 10px;
            font-size: 12px;
            color: #64748b;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .dots span {
            display: inline-block; width: 6px; height: 6px; background: #cbd5e1; border-radius: 50%;
            margin: 0 2px; animation: bounce 1s infinite;
        }
        .dots span:nth-child(2) { animation-delay: 0.2s; }
        .dots span:nth-child(3) { animation-delay: 0.4s; }
        @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-4px); } }
    </style>
</head>
<body>
    
    <!-- Navbar -->
    <div class="chat-app-bar d-flex align-items-center gap-3">
        <a href="<?= base_url('user/dashboard') ?>" class="text-white"><i class="bi bi-arrow-left fs-4"></i></a>
        <div class="d-flex align-items-center gap-2">
            <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                <i class="bi bi-robot"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0" style="font-size: 15px;">Tanya Pak RT (AI)</h6>
                <div class="d-flex align-items-center gap-1">
                    <span class="bg-success rounded-circle d-inline-block" style="width: 6px; height: 6px;"></span>
                    <small class="opacity-75" style="font-size: 11px;">Online 24 Jam</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Area -->
    <div class="chat-area" id="chatArea">
        <!-- Welcome -->
        <div class="d-flex justify-content-center my-3">
            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-1 fw-normal" style="font-size: 11px;">Hari ini</span>
        </div>

        <div class="message-bubble msg-bot">
            <strong>👋 Halo Warga!</strong><br>
            Saya asisten virtual RT Pintar. Ada yang bisa saya bantu terkait info lingkungan, iuran, atau administrasi?
            <div class="msg-time">Baru saja</div>
        </div>

        <!-- History -->
        <?php if(!empty($history)): ?>
            <?php foreach(array_reverse($history) as $h): ?>
                <div class="message-bubble msg-user">
                    <?= $h['question'] ?>
                    <div class="msg-time">Anda</div>
                </div>
                <div class="message-bubble msg-bot">
                    <?= $h['answer'] ?>
                    <div class="msg-time">Pak RT</div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="typing-pill" id="typingIndicator">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-robot"></i>
                <div class="dots"><span></span><span></span><span></span></div>
            </div>
        </div>
    </div>

    <!-- Footer Input -->
    <div class="c-footer">
        <div class="quick-actions">
            <div class="q-chip" onclick="askQuick('Jadwal pengangkatan sampah kapan?')">🗑️ Jadwal Sampah</div>
            <div class="q-chip" onclick="askQuick('Bagaimana cara bayar iuran?')">💰 Info Iuran</div>
            <div class="q-chip" onclick="askQuick('Nomor telepon satpam?')">👮 No. Satpam</div>
            <div class="q-chip" onclick="askQuick('Syarat surat pengantar nikah?')">💍 Surat Nikah</div>
        </div>
        
        <form id="chatForm" class="d-flex gap-2">
            <input type="text" id="questionInput" class="form-control rounded-4 border-0 bg-white py-3 px-4 shadow-sm" placeholder="Ketik pertanyaan..." required>
            <button type="submit" class="btn btn-primary rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <i class="bi bi-send-fill fs-5 ps-1"></i>
            </button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const chatArea = $('#chatArea');

        $('#chatForm').on('submit', function(e) {
            e.preventDefault();
            const q = $('#questionInput').val().trim();
            if(!q) return;
            sendMessage(q);
            $('#questionInput').val('');
        });

        function askQuick(q) {
            sendMessage(q);
        }

        function sendMessage(msg) {
            // Append User Msg
            const userHTML = `
                <div class="message-bubble msg-user">
                    ${msg}
                    <div class="msg-time">Baru saja</div>
                </div>
            `;
            $('#typingIndicator').before(userHTML);
            scrollToBottom();
            $('#typingIndicator').css('display', 'flex');

            // Send AJAX
            $.post('<?= base_url('user/chatbot/ask') ?>', { question: msg }, function(res) {
                $('#typingIndicator').hide();
                let reply = res.status ? res.answer : "Maaf, sistem sedang sibuk.";
                
                const botHTML = `
                    <div class="message-bubble msg-bot">
                        ${reply}
                        <div class="msg-time">Baru saja</div>
                    </div>
                `;
                $('#typingIndicator').before(botHTML);
                scrollToBottom();
            }, 'json').fail(function() {
                 $('#typingIndicator').hide();
            });
        }

        function scrollToBottom() {
            chatArea.scrollTop(chatArea[0].scrollHeight);
        }

        scrollToBottom();
    </script>
</body>
</html>
