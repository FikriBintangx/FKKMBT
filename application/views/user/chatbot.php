<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tanya Pak RT - AI Assistant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile.css') ?>">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .chat-container {
            flex: 1;
            max-width: 800px;
            width: 100%;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            height: calc(100vh - 60px);
        }
        .chat-header {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 20px 20px 0 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
        }
        .chat-input-area {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 -4px 6px rgba(0,0,0,0.1);
        }
        
        .message {
            margin-bottom: 15px;
            animation: slideIn 0.3s ease;
        }
        .message-user {
            text-align: right;
        }
        .message-bubble {
            display: inline-block;
            max-width: 70%;
            padding: 12px 18px;
            border-radius: 18px;
            word-wrap: break-word;
            white-space: pre-line;
        }
        .message-user .message-bubble {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-bottom-right-radius: 4px;
        }
        .message-bot .message-bubble {
            background: white;
            color: #333;
            border-bottom-left-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .message-time {
            font-size: 10px;
            opacity: 0.7;
            margin-top: 4px;
        }
        
        .quick-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }
        .quick-btn {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            cursor: pointer;
            transition: 0.3s;
        }
        .quick-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }
        
        .typing-indicator {
            display: none;
            padding: 10px;
        }
        .typing-indicator span {
            height: 10px;
            width: 10px;
            background: #999;
            border-radius: 50%;
            display: inline-block;
            margin: 0 2px;
            animation: bounce 1.4s infinite;
        }
        .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
        .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes bounce {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-10px); }
        }
        
        /* Scrollbar */
        .chat-messages::-webkit-scrollbar { width: 6px; }
        .chat-messages::-webkit-scrollbar-track { background: rgba(255,255,255,0.1); }
        .chat-messages::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 10px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="<?= base_url('user/dashboard') ?>">
                <i class="bi bi-arrow-left-circle me-2"></i> Dashboard
            </a>
        </div>
    </nav>

    <div class="chat-container my-3">
        <div class="chat-header">
            <div class="d-flex align-items-center justify-content-center gap-3">
                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width:50px;height:50px">
                    <i class="bi bi-robot fs-4 text-white"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Tanya Pak RT 🤖</h5>
                    <small class="text-muted">AI Assistant Warga FKKMBT</small>
                </div>
            </div>
        </div>

        <div class="chat-messages" id="chatMessages">
            <!-- Welcome Message -->
            <div class="message message-bot">
                <div class="message-bubble">
                    <strong>👋 Halo!</strong><br>
                    Saya Pak RT AI, siap membantu Anda 24/7!<br><br>
                    <strong>Tanyakan apapun tentang:</strong><br>
                    • Jadwal & Info Kompleks<br>
                    • Iuran & Pembayaran<br>
                    • Surat & Administrasi<br>
                    • Kontak Penting<br>
                    • Dan lainnya!
                </div>
                <div class="message-time text-white-50">Pak RT AI</div>
            </div>

            <!-- History Messages -->
            <?php if(!empty($history)): ?>
                <?php foreach(array_reverse($history) as $h): ?>
                    <div class="message message-user">
                        <div class="message-bubble"><?= $h['question'] ?></div>
                        <div class="message-time text-white-50">Anda</div>
                    </div>
                    <div class="message message-bot">
                        <div class="message-bubble"><?= $h['answer'] ?></div>
                        <div class="message-time text-white-50">Pak RT AI</div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="typing-indicator" id="typingIndicator">
                <div class="message-bubble bg-white">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </div>

        <div class="chat-input-area">
            <div class="quick-buttons">
                <button class="quick-btn" onclick="askQuick('Jadwal sampah kapan?')">Jadwal Sampah</button>
                <button class="quick-btn" onclick="askQuick('Berapa iuran bulanan?')">Info Iuran</button>
                <button class="quick-btn" onclick="askQuick('Nomor satpam berapa?')">Nomor Penting</button>
                <button class="quick-btn" onclick="askQuick('Cara buat surat domisili?')">Buat Surat</button>
            </div>
            <form id="chatForm" class="d-flex gap-2">
                <input type="text" id="questionInput" class="form-control form-control-lg rounded-pill" placeholder="Tanyakan sesuatu..." required>
                <button type="submit" class="btn btn-primary rounded-circle" style="width:50px;height:50px">
                    <i class="bi bi-send-fill"></i>
                </button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const chatMessages = $('#chatMessages');

        $('#chatForm').on('submit', function(e) {
            e.preventDefault();
            const question = $('#questionInput').val().trim();
            if (!question) return;

            sendMessage(question);
            $('#questionInput').val('');
        });

        function askQuick(question) {
            sendMessage(question);
        }

        function sendMessage(question) {
            // Show user message
            addMessage(question, 'user');

            // Show typing indicator
            $('#typingIndicator').show();
            scrollToBottom();

            // Send to backend
            $.post('<?= base_url('user/chatbot/ask') ?>', {
                question: question
            }, function(response) {
                $('#typingIndicator').hide();
                
                if (response.status) {
                    addMessage(response.answer, 'bot');
                } else {
                    addMessage('Maaf, terjadi kesalahan. Coba lagi nanti.', 'bot');
                }
            }, 'json').fail(function() {
                $('#typingIndicator').hide();
                addMessage('Maaf, koneksi bermasalah. Coba lagi nanti.', 'bot');
            });
        }

        function addMessage(text, type) {
            const messageClass = type === 'user' ? 'message-user' : 'message-bot';
            const label = type === 'user' ? 'Anda' : 'Pak RT AI';
            
            const messageHtml = `
                <div class="message ${messageClass}">
                    <div class="message-bubble">${text}</div>
                    <div class="message-time ${type === 'user' ? 'text-white-50' : 'text-white-50'}">${label}</div>
                </div>
            `;
            
            $('#typingIndicator').before(messageHtml);
            scrollToBottom();
        }

        function scrollToBottom() {
            chatMessages[0].scrollTop = chatMessages[0].scrollHeight;
        }

        scrollToBottom();
    </script>
</body>
</html>
