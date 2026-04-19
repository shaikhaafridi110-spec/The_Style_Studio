<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>The_Style_Studio</title>
    <link rel="icon" type="image/png" sizes="64x64" href="{{asset('user/assets/images/logo11.png')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{asset('user/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('user/assets/css/plugins/owl-carousel/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('user/assets/css/plugins/magnific-popup/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('user/assets/css/plugins/jquery.countdown.css')}}">
    <link rel="stylesheet" href="{{asset('user/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('user/assets/css/skins/skin-demo-5.css')}}">
    <link rel="stylesheet" href="{{asset('user/assets/css/demos/demo-5.css')}}">

    <style>
        /* ── Navbar ───────────────────────────────────── */
        .main-nav .menu>li>a {
            padding: 0px 20px;
            line-height: 2;
            display: inline-block;
        }

        .settings-dropdown .dropdown-menu {
            min-width: 180px;
            padding: 10px 0;
        }

        .settings-dropdown .dropdown-menu a {
            padding: 8px 20px;
            display: block;
            color: #333;
        }

        .settings-dropdown .dropdown-menu a:hover {
            background: #f5f5f5;
        }

        .settings-dropdown {
            position: relative;
            margin-left: 20px;
        }

        .settings-dropdown i {
            font-size: 22px;
        }

        .settings-dropdown>a {
            color: #fff !important;
            display: flex;
            align-items: center;
            font-size: 22px;
        }

        .settings-dropdown>a:hover {
            color: #cc9966 !important;
        }

        .settings-dropdown .dropdown-toggle::after {
            display: none !important;
        }

        /* ── Chat Toggle Button ───────────────────────── */
        #chat-toggle {
            position: fixed;
            bottom: 28px;
            right: 28px;
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: #1a1a1a;
            color: #fff;
            border: none;
            font-size: 24px;
            cursor: pointer;
            z-index: 9999;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.25s ease, transform 0.2s ease;
        }

        #chat-toggle:hover {
            background: #e63946;
            transform: scale(1.08);
        }

        /* ── Chat Window ──────────────────────────────── */
        #chat-window {
            position: fixed;
            bottom: 100px;
            right: 28px;
            width: 360px;
            height: 500px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.18);
            display: none;
            flex-direction: column;
            z-index: 9998;
            overflow: hidden;
            font-family: inherit;
            animation: chatSlideUp 0.3s ease;
        }

        #chat-window.open {
            display: flex;
        }

        @keyframes chatSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── Header ───────────────────────────────────── */
        .chat-header {
            background: #1a1a1a;
            color: #fff;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .chat-header-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #c8a96e;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .chat-header-info h4 {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
        }

        .chat-header-info span {
            font-size: 11px;
            opacity: 0.65;
        }

        .chat-header-close {
            margin-left: auto;
            background: none;
            border: none;
            color: #fff;
            font-size: 22px;
            cursor: pointer;
            opacity: 0.7;
            line-height: 1;
            padding: 0;
        }

        .chat-header-close:hover {
            opacity: 1;
        }

        /* ── Messages ─────────────────────────────────── */
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            background: #f9f9f9;
        }

        .chat-messages::-webkit-scrollbar {
            width: 4px;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 4px;
        }

        /* ── Bubbles ──────────────────────────────────── */
        .chat-bubble {
            max-width: 80%;
            padding: 10px 14px;
            border-radius: 16px;
            font-size: 13.5px;
            line-height: 1.6;
            word-break: break-word;
        }

        .chat-bubble.bot {
            background: #fff;
            color: #1a1a1a;
            border-bottom-left-radius: 4px;
            align-self: flex-start;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
        }

        .chat-bubble.user {
            background: #1a1a1a;
            color: #fff;
            border-bottom-right-radius: 4px;
            align-self: flex-end;
        }

        /* ── Typing Dots ──────────────────────────────── */
        .chat-typing {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 12px 16px;
            background: #fff;
            border-radius: 16px;
            border-bottom-left-radius: 4px;
            align-self: flex-start;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
            width: fit-content;
        }

        .chat-typing span {
            width: 7px;
            height: 7px;
            background: #bbb;
            border-radius: 50%;
            animation: typingBounce 1.2s infinite ease-in-out;
        }

        .chat-typing span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .chat-typing span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typingBounce {

            0%,
            80%,
            100% {
                transform: translateY(0);
                background: #bbb;
            }

            40% {
                transform: translateY(-7px);
                background: #555;
            }
        }

        /* ── Quick Replies ────────────────────────────── */
        .quick-replies {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            padding: 8px 14px 10px;
            background: #f9f9f9;
            border-top: 1px solid #eee;
            flex-shrink: 0;
        }

        .quick-reply-btn {
            background: #fff;
            border: 1.5px solid #ddd;
            border-radius: 20px;
            padding: 5px 12px;
            font-size: 12px;
            cursor: pointer;
            color: #444;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .quick-reply-btn:hover {
            background: #1a1a1a;
            color: #fff;
            border-color: #1a1a1a;
        }

        /* ── Input Area ───────────────────────────────── */
        .chat-input-area {
            padding: 12px 14px;
            border-top: 1px solid #eee;
            display: flex;
            gap: 8px;
            background: #fff;
            flex-shrink: 0;
        }

        .chat-input-area input {
            flex: 1;
            border: 1.5px solid #eee;
            border-radius: 30px;
            padding: 10px 16px;
            font-size: 13px;
            outline: none;
            transition: border-color 0.2s ease;
        }

        .chat-input-area input:focus {
            border-color: #c8a96e;
        }

        .chat-send-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #1a1a1a;
            color: #fff;
            border: none;
            font-size: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background 0.2s ease;
        }

        .chat-send-btn:hover {
            background: #c8a96e;
        }

        .chat-send-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        /* ── Mobile ───────────────────────────────────── */
        @media (max-width: 480px) {
            #chat-window {
                width: calc(100vw - 20px);
                right: 10px;
                bottom: 90px;
                height: 460px;
            }

            #chat-toggle {
                right: 16px;
                bottom: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="page-wrapper">

        {{-- ── Header ── --}}
        <header class="header header-5">
            <div class="header-middle sticky-header">
                <div class="container-fluid">
                    <div class="header-left">
                        <a href="{{url('/')}}" class="logo">
                            <img src="{{asset('user/assets/images/logo03.png')}}" alt="Molla Logo" width="105" height="25">
                        </a>
                        <nav class="main-nav">
                            <ul class="menu sf-arrows">
                                <li class="megamenu-container" style="width:fit-content;">
                                    <a href="{{url('/')}}">Home</a>
                                </li>
                                <li><a href="{{url('user/shop')}}">Shop</a></li>
                                <li><a href="{{url('user/about')}}">About</a></li>
                                <li><a href="{{url('user/contact')}}">Contact</a></li>
                                <li>
                                    @if(!Auth::check())
                                    <a href="{{url('/login')}}">Login</a>
                                    @endif
                                </li>
                            </ul>
                        </nav>
                    </div>

                    @if(!Request::is('login'))
                    <div class="header-right">
                        <div class="header-search header-search-extended header-search-visible">
                            <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                            <form action="{{url('user/shop')}}" method="get">
                                <div class="header-search-wrapper">
                                    <label for="q" class="sr-only">Search</label>
                                    <input type="search" class="form-control" name="search"
                                        id="q" placeholder="Search product ..." required>
                                    <button class="btn btn-primary" type="submit">
                                        <i class="icon-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        @if(Auth::check())
                        <a href="{{url('user/wishlist')}}" class="wishlist-link">
                            <i class="icon-heart-o"></i>
                        </a>
                        <a href="{{url('user/cart')}}" class="wishlist-link">
                            <i class="icon-shopping-cart"></i>
                        </a>
                        <div class="dropdown settings-dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-cog"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{url('profile')}}">
                                    <i class="fa fa-user mr-2"></i> My Profile
                                </a>
                                <a class="dropdown-item" href="{{ route('user.categories') }}">
                                    <i class="fa fa-th-large mr-2"></i> Category
                                </a>
                                <a class="dropdown-item" href="{{url('orders')}}">
                                    <i class="fa fa-box mr-2"></i> My Orders
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{url('logout')}}">
                                    <i class="fa fa-sign-out-alt mr-2"></i> Logout
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </header>

        {{-- ── Page Content ── --}}
        @yield('content')

        {{-- ── Footer ── --}}
        <footer class="footer footer-2">
            <div class="footer-middle border-0">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            <div class="widget widget-about">
                                <img src="{{asset('user/assets/images/logo10.png')}}"
                                    class="footer-logo" alt="Footer Logo" width="200" height="25">
                                <p style="font-size:16px; line-height:1.8;">
                                    At <strong>Style Studio</strong>, we bring you timeless fashion with a modern touch,
                                    crafted to express your unique personality and confidence.
                                </p>
                                <p style="font-size:16px; line-height:1.8;">
                                    <strong>--</strong> Fashion that speaks your style only at Style Studio.
                                </p>
                                <div class="widget-about-info">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-4">
                                            <span class="widget-about-title">Got Question? Call us 24/7</span>
                                            <a href="tel:123456789" style="color:#D4AF37;">+0123 456 789</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-lg-2"></div>

                        <div class="col-sm-4 col-lg-2">
                            <div class="widget">
                                <h4 class="widget-title">Pages</h4>
                                <ul class="widget-list">
                                    <li><a href="{{url('user/shop')}}">Shop</a></li>
                                    <li><a href="{{url('user/about')}}">About Us</a></li>
                                    <li><a href="{{url('user/contact')}}">Contact us</a></li>
                                    @if(!Auth::check())
                                    <li><a href="{{url('/login')}}">Log in</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="col-sm-4 col-lg-2">
                            <div class="widget">
                                <h4 class="widget-title">My Account</h4>
                                <ul class="widget-list">
                                    @if(Auth::check())
                                    <li><a href="{{url('user/wishlist')}}">My Wishlist</a></li>
                                    <li><a href="{{url('user/cart')}}">Cart</a></li>
                                    <li><a href="{{url('orders')}}">My Orders</a></li>
                                    @endif
                                    <li><a href="{{url('user/contact')}}">Help</a></li>
                                    @if(Auth::check())
                                    <li><a href="{{url('logout')}}">Log Out</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="container">
                    <p class="footer-copyright">
                        Copyright © 2026 The_Style_Studio. All Rights Reserved.
                    </p>
                    <ul class="footer-menu">
                        <li><a href="#">Terms Of Use</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                    <div class="social-icons social-icons-color">
                        <span class="social-label">Social Media</span>
                        <a href="#" class="social-icon social-facebook" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                        <a href="#" class="social-icon social-twitter" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                        <a href="#" class="social-icon social-instagram" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                        <a href="#" class="social-icon social-youtube" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>
                        <a href="#" class="social-icon social-pinterest" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </footer>

    </div>{{-- End .page-wrapper --}}

    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    {{-- ═══════════════════════════════════════
     CHATBOT WIDGET
════════════════════════════════════════ --}}

    <button id="chat-toggle" title="Chat with Style Studio">💬</button>

    <div id="chat-window">

        <div class="chat-header">
            <div class="chat-header-avatar">👗</div>
            <div class="chat-header-info">
                <h4>Style Studio Assistant</h4>
                <span>🟢 Online | Style Studio AI</span>
            </div>
            <button class="chat-header-close" id="chat-close">&times;</button>
        </div>

        <div class="chat-messages" id="chatMessages"></div>

        <div class="quick-replies" id="quickReplies">
            <button class="quick-reply-btn" onclick="sendQuick('What products do you have?')">👗 Products</button>
            <button class="quick-reply-btn" onclick="sendQuick('What are your most popular products?')">🔥 Popular</button>
            <button class="quick-reply-btn" onclick="sendQuick('How do I track my order?')">📦 My Order</button>
            <button class="quick-reply-btn" onclick="sendQuick('What is your return policy?')">🔄 Returns</button>
        </div>

        <div class="chat-input-area">
            <input type="text"
                id="chatInput"
                placeholder="Ask me anything…"
                autocomplete="off"
                maxlength="300">
            <button class="chat-send-btn" id="chatSendBtn" title="Send">
                <i class="fa fa-paper-plane"></i>
            </button>
        </div>

    </div>

    {{-- JS Scripts --}}
    <script src="{{asset('user/assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('user/assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('user/assets/js/jquery.hoverIntent.min.js')}}"></script>
    <script src="{{asset('user/assets/js/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('user/assets/js/superfish.min.js')}}"></script>
    <script src="{{asset('user/assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('user/assets/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('user/assets/js/jquery.plugin.min.js')}}"></script>
    <script src="{{asset('user/assets/js/jquery.countdown.min.js')}}"></script>
    <script src="{{asset('user/assets/js/main.js')}}"></script>
    <script src="{{asset('user/assets/js/demos/demo-5.js')}}"></script>

    <script>
        const chatToggle = document.getElementById('chat-toggle');
        const chatWindow = document.getElementById('chat-window');
        const chatClose = document.getElementById('chat-close');
        const chatMessages = document.getElementById('chatMessages');
        const chatInput = document.getElementById('chatInput');
        const chatSendBtn = document.getElementById('chatSendBtn');
        const quickReplies = document.getElementById('quickReplies');

        let isOpen = false;
        let isFirstOpen = true;

        // ── Open / Close ──────────────────────────────────────────
        chatToggle.addEventListener('click', function() {
            isOpen = !isOpen;
            chatWindow.classList.toggle('open', isOpen);
            chatToggle.innerHTML = isOpen ? '✕' : '💬';

            if (isOpen && isFirstOpen) {
                isFirstOpen = false;
                setTimeout(function() {
                    appendBot("👋 Hi! Welcome to Style Studio! I can help you with products, sizes, prices and orders. How can I help you today?");
                }, 300);
            }
        });

        chatClose.addEventListener('click', function() {
            isOpen = false;
            chatWindow.classList.remove('open');
            chatToggle.innerHTML = '💬';
        });

        // ── Bot Bubble ────────────────────────────────────────────
        function appendBot(text) {
            const div = document.createElement('div');
            div.className = 'chat-bubble bot';
            div.textContent = text;
            chatMessages.appendChild(div);
            scrollToBottom();
        }

        // ── User Bubble ───────────────────────────────────────────
        function appendUser(text) {
            const div = document.createElement('div');
            div.className = 'chat-bubble user';
            div.textContent = text;
            chatMessages.appendChild(div);
            quickReplies.style.display = 'none';
            scrollToBottom();
        }

        // ── Typing Indicator ──────────────────────────────────────
        function showTyping() {
            const div = document.createElement('div');
            div.className = 'chat-typing';
            div.id = 'typingIndicator';
            div.innerHTML = '<span></span><span></span><span></span>';
            chatMessages.appendChild(div);
            scrollToBottom();
            return div;
        }

        // ── Scroll ────────────────────────────────────────────────
        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // ── Send ──────────────────────────────────────────────────
        function sendMessage(text) {
            text = (text || chatInput.value).trim();
            if (!text) return;

            appendUser(text);
            chatInput.value = '';
            chatSendBtn.disabled = true;

            const typing = showTyping();

            fetch("{{ route('user.chatbot') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        message: text
                    })
                })
                .then(function(res) {
                    return res.json();
                })
                .then(function(data) {
                    typing.remove();
                    appendBot(data.reply || 'Sorry, I could not process that. Please try again.');
                    chatSendBtn.disabled = false;

                    // ── Handle page redirects ──────────────────────────────
                    // ── Handle page redirects ONLY if user explicitly asked ──
                    var explicitRedirect = /\b(go to|open|take me|redirect|navigate|visit page|show me the page)\b/i.test(text);

                    if (data.redirect && explicitRedirect) {
                        var urls = {
                            'shop': "{{ url('user/shop') }}",
                            'cart': "{{ url('user/cart') }}",
                            'orders': "{{ url('orders') }}",
                            'wishlist': "{{ url('user/wishlist') }}",
                            'profile': "{{ url('profile') }}",
                            'categories': "{{ url('user/categories') }}",
                            'about': "{{ url('user/about') }}",
                            'contact': "{{ url('user/contact') }}",
                            'home': "{{ url('/') }}"
                        };

                        var targetUrl = urls[data.redirect.toLowerCase()];
                        if (targetUrl) {
                            setTimeout(function() {
                                appendBot('🔗 Redirecting you now...');
                                setTimeout(function() {
                                    window.location.href = targetUrl;
                                }, 1000);
                            }, 800);
                        }
                    }
                })
                .catch(function() {
                    typing.remove();
                    appendBot('⚠️ Something went wrong. Please try again.');
                    chatSendBtn.disabled = false;
                });
        }
        // ── Quick Reply ───────────────────────────────────────────
        function sendQuick(text) {
            sendMessage(text);
        }

        // ── Events ────────────────────────────────────────────────
        chatSendBtn.addEventListener('click', function() {
            sendMessage(chatInput.value);
        });

        chatInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage(chatInput.value);
            }
        });
    </script>

    @stack('scripts')

</body>

</html>