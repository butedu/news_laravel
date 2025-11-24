@props(['status'])
@if(session()->has($status))
    @php
        $statusToTone = [
            'success' => 'success',
            'info' => 'info',
            'warning' => 'warning',
            'error' => 'danger',
            'danger' => 'danger',
        ];

        $tone = $statusToTone[$status] ?? 'info';
        $toneLabel = [
            'success' => 'Thành công',
            'info' => 'Thông báo',
            'warning' => 'Cảnh báo',
            'danger' => 'Lỗi',
        ][$tone] ?? 'Thông báo';

        $toneIcon = [
            'success' => 'OK',
            'info' => 'i',
            'warning' => '!',
            'danger' => 'x',
        ][$tone] ?? 'i';

        $payload = [
            'tone' => $tone,
            'icon' => $toneIcon,
            'title' => $toneLabel,
            'message' => session($status),
        ];
    @endphp

    @once
        <style>
            .flash-toast-root{
                position: fixed;
                top: 24px;
                right: 24px;
                z-index: 1050;
                display: flex;
                flex-direction: column;
                gap: 12px;
                max-width: 320px;
                pointer-events: none;
            }
            .flash-toast{
                display: flex;
                align-items: flex-start;
                gap: 12px;
                border-radius: 12px;
                padding: 14px 16px;
                background: #0f172a;
                color: #fff;
                box-shadow: 0 18px 40px rgba(15,23,42,0.22);
                border: 1px solid rgba(255,255,255,0.08);
                transform: translateY(-8px);
                opacity: 0;
                transition: opacity 0.25s ease, transform 0.25s ease;
                pointer-events: auto;
            }
            .flash-toast.is-visible{
                opacity: 1;
                transform: translateY(0);
            }
            .flash-toast__icon{
                font-weight: 700;
                font-size: 14px;
                width: 28px;
                height: 28px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                background: rgba(255,255,255,0.14);
            }
            .flash-toast__body{
                flex: 1;
            }
            .flash-toast__title{
                margin: 0 0 4px;
                font-weight: 700;
                font-size: 15px;
                letter-spacing: .01em;
            }
            .flash-toast__message{
                margin: 0;
                font-size: 14px;
                line-height: 1.4;
                color: rgba(255,255,255,0.86);
            }
            .flash-toast__close{
                border: none;
                background: transparent;
                color: rgba(255,255,255,0.72);
                font-size: 18px;
                cursor: pointer;
                line-height: 1;
                padding: 0 4px;
            }
            .flash-toast--success{background: linear-gradient(135deg,#0ea5e9,#2563eb);} 
            .flash-toast--info{background: linear-gradient(135deg,#6366f1,#4338ca);} 
            .flash-toast--warning{background: linear-gradient(135deg,#f59e0b,#d97706);} 
            .flash-toast--danger{background: linear-gradient(135deg,#f97316,#ef4444);} 
        </style>
        <script>
            (function(){
                function ensureRoot(){
                    var existing = document.getElementById('flash-toast-root');
                    if(existing){ return existing; }
                    var root = document.createElement('div');
                    root.id = 'flash-toast-root';
                    root.className = 'flash-toast-root';
                    document.body.appendChild(root);
                    return root;
                }

                function createToast(data){
                    var wrapper = document.createElement('div');
                    wrapper.innerHTML = '' +
                        '<div class="flash-toast flash-toast--' + data.tone + ' global-message" data-flash-toast role="alert">' +
                            '<span class="flash-toast__icon" aria-hidden="true">' + data.icon + '</span>' +
                            '<div class="flash-toast__body">' +
                                '<p class="flash-toast__title">' + data.title + '</p>' +
                                '<p class="flash-toast__message">' + data.message + '</p>' +
                            '</div>' +
                            '<button type="button" class="flash-toast__close" data-flash-toast-close aria-label="Đóng">&times;</button>' +
                        '</div>';
                    return wrapper.firstChild;
                }

                window.renderFlashToast = function(data){
                    var root = ensureRoot();
                    var toast = createToast(data);
                    root.appendChild(toast);
                    requestAnimationFrame(function(){
                        toast.classList.add('is-visible');
                    });
                    var hideTimer = setTimeout(function(){
                        toast.classList.remove('is-visible');
                        setTimeout(function(){ toast.remove(); }, 240);
                    }, 4800);
                    var close = toast.querySelector('[data-flash-toast-close]');
                    if(close){
                        close.addEventListener('click', function(){
                            clearTimeout(hideTimer);
                            toast.classList.remove('is-visible');
                            setTimeout(function(){ toast.remove(); }, 200);
                        });
                    }
                };
            })();
        </script>
    @endonce

    <script>
        window.renderFlashToast && window.renderFlashToast({!! json_encode($payload, JSON_HEX_APOS | JSON_HEX_QUOT) !!});
    </script>
@endif