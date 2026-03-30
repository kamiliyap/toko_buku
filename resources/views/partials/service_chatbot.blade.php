@php
    $chatStoreName = $storeSettings['store_name'] ?? 'Toko Buku Pintar';
    $chatTagline = $storeSettings['tagline'] ?? 'Buku pendidikan dan literatur';
    $chatEmail = $storeSettings['contact_email'] ?? 'halo@tokobukupintar.id';
    $chatPhone = $storeSettings['contact_phone'] ?? '+62 812-3456-7890';
    $chatAddress = $storeSettings['address'] ?? 'Jl. Pintar No. 1, Jakarta Selatan';
    $waPhone = preg_replace('/\D+/', '', $chatPhone);
    $faqPayload = [
        [
            'keywords' => ['halo', 'hai', 'hello', 'hi'],
            'answer' => "Halo, selamat datang di {$chatStoreName}. Ada yang bisa kami bantu hari ini?",
        ],
        [
            'keywords' => ['pengiriman', 'kirim', 'kurir', 'delivery'],
            'answer' => 'Kami melayani pengiriman lewat kurir lokal dan ekspedisi nasional. Estimasi pengiriman menyesuaikan alamat tujuan dan stok buku.',
        ],
        [
            'keywords' => ['bayar', 'pembayaran', 'transfer', 'metode bayar'],
            'answer' => 'Untuk pembayaran, silakan lanjut ke checkout lalu ikuti instruksi yang tersedia. Jika butuh konfirmasi manual, kami siap bantu lewat kontak admin.',
        ],
        [
            'keywords' => ['stok', 'tersedia', 'ready'],
            'answer' => 'Cek label stok di kartu buku. Jika judul yang dicari belum tersedia, kirim nama bukunya ke admin agar kami bantu cek ulang.',
        ],
        [
            'keywords' => ['return', 'retur', 'pengembalian', 'rusak'],
            'answer' => 'Pengembalian bisa diproses jika buku rusak saat diterima. Simpan bukti foto dan hubungi admin secepatnya ya.',
        ],
        [
            'keywords' => ['alamat', 'lokasi', 'toko'],
            'answer' => "Alamat kami di {$chatAddress}.",
        ],
        [
            'keywords' => ['kontak', 'whatsapp', 'wa', 'admin', 'cs'],
            'answer' => "Silakan hubungi admin di {$chatPhone} atau email {$chatEmail}.",
        ],
        [
            'keywords' => ['jam', 'buka', 'operasional'],
            'answer' => 'Layanan online kami aktif setiap hari. Jika admin belum membalas saat itu juga, pesan Anda tetap kami tindak lanjuti secepat mungkin.',
        ],
        [
            'keywords' => ['promo', 'diskon'],
            'answer' => 'Promo dan diskon terbaru biasanya tampil di banner beranda. Kalau mau dibantu cek promo aktif, kirim pertanyaannya ke admin ya.',
        ],
    ];
@endphp

<div class="svc-chatbot" data-service-chatbot>
    <button
        type="button"
        class="svc-chatbot__trigger"
        id="svc-chatbot-trigger"
        aria-expanded="false"
        aria-controls="svc-chatbot-panel"
    >
        <span class="svc-chatbot__trigger-icon"><i class="bi bi-chat-dots-fill"></i></span>
        <span class="svc-chatbot__trigger-text">Butuh Bantuan?</span>
    </button>

    <section
        class="svc-chatbot__panel"
        id="svc-chatbot-panel"
        aria-hidden="true"
        aria-label="Chatbot pelayanan pelanggan"
    >
        <header class="svc-chatbot__header">
            <div>
                <strong>Pelayanan {{ $chatStoreName }}</strong>
                <p>{{ $chatTagline }}</p>
            </div>
            <button type="button" class="svc-chatbot__close" aria-label="Tutup chat">
                <i class="bi bi-x-lg"></i>
            </button>
        </header>

        <div class="svc-chatbot__messages" id="svc-chatbot-messages"></div>

        <div class="svc-chatbot__quick-actions">
            <button type="button" data-chatbot-quick="pengiriman">Pengiriman</button>
            <button type="button" data-chatbot-quick="stok buku">Cek Stok</button>
            <button type="button" data-chatbot-quick="kontak admin">Kontak Admin</button>
            <button type="button" data-chatbot-quick="retur buku">Retur</button>
        </div>

        <form class="svc-chatbot__form" id="svc-chatbot-form">
            <input
                type="text"
                id="svc-chatbot-input"
                placeholder="Tulis pertanyaan Anda..."
                autocomplete="off"
            >
            <button type="submit" aria-label="Kirim pesan">
                <i class="bi bi-send-fill"></i>
            </button>
        </form>

        <div class="svc-chatbot__footer">
            <a
                href="{{ $waPhone ? 'https://wa.me/' . $waPhone : 'mailto:' . $chatEmail }}"
                target="_blank"
                rel="noreferrer"
            >
                <i class="bi bi-headset"></i>
                Hubungi Admin Langsung
            </a>
        </div>
    </section>
</div>

<style>
            .svc-chatbot {
                position: fixed;
                right: 22px;
                bottom: 22px;
                z-index: 2300;
                display: flex;
                flex-direction: column;
                align-items: flex-end;
                gap: 12px;
            }

            .svc-chatbot__trigger {
                border: 0;
                border-radius: 999px;
                padding: 12px 16px;
                background: linear-gradient(135deg, #0f172a, #2563eb 58%, #06b6d4);
                color: #fff;
                box-shadow: 0 16px 36px rgba(15, 23, 42, 0.24);
                display: inline-flex;
                align-items: center;
                gap: 10px;
                font-weight: 700;
            }

            .svc-chatbot__trigger-icon {
                width: 40px;
                height: 40px;
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.14);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 1.1rem;
            }

            .svc-chatbot__panel {
                width: min(380px, calc(100vw - 24px));
                max-height: min(620px, calc(100vh - 110px));
                background: #fff;
                border-radius: 24px;
                box-shadow: 0 24px 54px rgba(15, 23, 42, 0.2);
                overflow: hidden;
                display: none;
                border: 1px solid rgba(148, 163, 184, 0.22);
            }

            .svc-chatbot__panel.is-open {
                display: flex;
                flex-direction: column;
            }

            .svc-chatbot__header {
                padding: 18px 18px 16px;
                background:
                    radial-gradient(circle at top right, rgba(255, 255, 255, 0.18), transparent 28%),
                    linear-gradient(135deg, #4f46e5, #2563eb 60%, #06b6d4);
                color: #fff;
                display: flex;
                justify-content: space-between;
                gap: 14px;
            }

            .svc-chatbot__header strong {
                display: block;
                font-size: 1rem;
                margin-bottom: 4px;
            }

            .svc-chatbot__header p {
                margin: 0;
                font-size: 0.86rem;
                color: rgba(255, 255, 255, 0.84);
            }

            .svc-chatbot__close {
                border: 0;
                background: rgba(255, 255, 255, 0.16);
                color: #fff;
                width: 36px;
                height: 36px;
                border-radius: 12px;
                flex-shrink: 0;
            }

            .svc-chatbot__messages {
                padding: 16px;
                background:
                    radial-gradient(circle at top left, rgba(96, 165, 250, 0.08), transparent 34%),
                    #f8fafc;
                display: flex;
                flex-direction: column;
                gap: 12px;
                overflow-y: auto;
                min-height: 260px;
            }

            .svc-chatbot__bubble {
                max-width: 86%;
                padding: 11px 13px;
                border-radius: 16px;
                font-size: 0.93rem;
                line-height: 1.5;
                white-space: pre-line;
                box-shadow: 0 10px 26px rgba(15, 23, 42, 0.08);
            }

            .svc-chatbot__bubble--bot {
                align-self: flex-start;
                background: #fff;
                color: #0f172a;
                border-top-left-radius: 8px;
            }

            .svc-chatbot__bubble--user {
                align-self: flex-end;
                background: linear-gradient(135deg, #2563eb, #1d4ed8);
                color: #fff;
                border-top-right-radius: 8px;
            }

            .svc-chatbot__quick-actions {
                padding: 12px 14px 0;
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                background: #fff;
            }

            .svc-chatbot__quick-actions button {
                border: 1px solid #dbeafe;
                border-radius: 999px;
                padding: 7px 12px;
                background: #eff6ff;
                color: #1d4ed8;
                font-size: 0.83rem;
                font-weight: 600;
            }

            .svc-chatbot__form {
                display: flex;
                gap: 10px;
                padding: 14px;
                background: #fff;
            }

            .svc-chatbot__form input {
                flex: 1;
                border: 1px solid #cbd5e1;
                border-radius: 16px;
                padding: 12px 14px;
                outline: none;
                font-size: 0.92rem;
            }

            .svc-chatbot__form input:focus {
                border-color: #60a5fa;
                box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.16);
            }

            .svc-chatbot__form button {
                width: 48px;
                height: 48px;
                border: 0;
                border-radius: 16px;
                background: linear-gradient(135deg, #4f46e5, #2563eb);
                color: #fff;
                flex-shrink: 0;
            }

            .svc-chatbot__footer {
                padding: 0 14px 14px;
                background: #fff;
            }

            .svc-chatbot__footer a {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                color: #0f766e;
                font-weight: 700;
                text-decoration: none;
            }

            @media (max-width: 640px) {
                .svc-chatbot {
                    right: 14px;
                    bottom: 14px;
                    left: 14px;
                    align-items: stretch;
                }

                .svc-chatbot__trigger {
                    justify-content: center;
                }

                .svc-chatbot__panel {
                    width: 100%;
                    max-height: calc(100vh - 96px);
                }

                .svc-chatbot__trigger-text {
                    display: none;
                }
            }
        </style>

<script>
            document.addEventListener('DOMContentLoaded', function () {
                const root = document.querySelector('[data-service-chatbot]');

                if (!root) {
                    return;
                }

                const trigger = root.querySelector('#svc-chatbot-trigger');
                const panel = root.querySelector('#svc-chatbot-panel');
                const closeButton = root.querySelector('.svc-chatbot__close');
                const messages = root.querySelector('#svc-chatbot-messages');
                const form = root.querySelector('#svc-chatbot-form');
                const input = root.querySelector('#svc-chatbot-input');
                const quickButtons = root.querySelectorAll('[data-chatbot-quick]');
                const faq = @json($faqPayload);
                const storeName = @json($chatStoreName);
                const contactEmail = @json($chatEmail);
                const contactPhone = @json($chatPhone);

                let seeded = false;

                function setOpen(open) {
                    panel.classList.toggle('is-open', open);
                    panel.setAttribute('aria-hidden', open ? 'false' : 'true');
                    trigger.setAttribute('aria-expanded', open ? 'true' : 'false');

                    if (open && !seeded) {
                        seedConversation();
                    }

                    if (open) {
                        window.setTimeout(function () {
                            input.focus();
                            messages.scrollTop = messages.scrollHeight;
                        }, 60);
                    }
                }

                function appendMessage(content, type) {
                    const bubble = document.createElement('div');
                    bubble.className = 'svc-chatbot__bubble svc-chatbot__bubble--' + type;
                    bubble.textContent = content;
                    messages.appendChild(bubble);
                    messages.scrollTop = messages.scrollHeight;
                }

                function seedConversation() {
                    seeded = true;
                    appendMessage('Halo, saya asisten pelayanan ' + storeName + '. Silakan tanya soal pengiriman, stok, retur, atau kontak admin.', 'bot');
                    appendMessage('Anda juga bisa klik tombol cepat di bawah untuk pertanyaan umum.', 'bot');
                }

                function findReply(question) {
                    const normalized = question.toLowerCase();

                    for (const item of faq) {
                        if (item.keywords.some(function (keyword) { return normalized.includes(keyword); })) {
                            return item.answer;
                        }
                    }

                    return 'Terima kasih, pesan Anda sudah kami terima. Untuk bantuan lebih lanjut, silakan hubungi admin di ' + contactPhone + ' atau email ' + contactEmail + '.';
                }

                function submitQuestion(text) {
                    const question = text.trim();

                    if (!question) {
                        return;
                    }

                    appendMessage(question, 'user');
                    input.value = '';

                    window.setTimeout(function () {
                        appendMessage(findReply(question), 'bot');
                    }, 320);
                }

                trigger.addEventListener('click', function () {
                    setOpen(!panel.classList.contains('is-open'));
                });

                closeButton.addEventListener('click', function () {
                    setOpen(false);
                });

                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    submitQuestion(input.value);
                });

                quickButtons.forEach(function (button) {
                    button.addEventListener('click', function () {
                        submitQuestion(button.dataset.chatbotQuick || '');
                    });
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape' && panel.classList.contains('is-open')) {
                        setOpen(false);
                    }
                });
            });
        </script>
