@php
    $poll = [
        'question' => 'Theo bạn đội bóng nào sẽ vô địch World Cup 2026?',
        'description' => 'Chia sẻ dự đoán của bạn và xem cộng đồng đang nghiêng về cái tên nào.',
        'options' => [
            [
                'id' => 'poll-option-bra',
                'label' => 'Brazil',
                'flag' => 'Flag_barzill.png',
                'percent' => 43,
            ],
            [
                'id' => 'poll-option-arg',
                'label' => 'Argentina',
                'flag' => 'Flag_Agrennal.png',
                'percent' => 31,
            ],
            [
                'id' => 'poll-option-esp',
                'label' => 'Tây Ban Nha',
                'flag' => 'Flag_tay_ban_nha.png',
                'percent' => 16,
            ],
            [
                'id' => 'poll-option-por',
                'label' => 'Bồ Đào Nha',
                'flag' => 'Flag_bo-dao-nha.png',
                'percent' => 10,
            ],
        ],
    ];
@endphp

<div class="sidebar-widget sidebar-widget-poll">
    <h3 class="widget-title"><i class="fa fa-pie-chart"></i> Bình chọn nhanh</h3>
    <div class="widget-content">
        <style>
            .sidebar-widget-poll {
                position: relative;
            }

            .sidebar-widget-poll .poll-card {
                background: linear-gradient(135deg, rgba(9, 89, 171, 0.07), rgba(44, 133, 223, 0.05));
                border: 1px solid rgba(15, 23, 42, 0.06);
                border-radius: 20px;
                padding: 22px;
                display: flex;
                flex-direction: column;
                gap: 18px;
            }

            .sidebar-widget-poll .poll-meta {
                display: flex;
                flex-direction: column;
                gap: 6px;
            }

            .sidebar-widget-poll .poll-question {
                font-size: 18px;
                font-weight: 700;
                color: #0f172a;
                margin: 0;
            }

            .sidebar-widget-poll .poll-description {
                font-size: 14px;
                color: #475569;
                margin: 0;
                line-height: 1.6;
            }

            .sidebar-widget-poll .poll-options {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .sidebar-widget-poll .poll-option {
                background: #fff;
                border: 1px solid rgba(15, 23, 42, 0.06);
                border-radius: 14px;
                padding: 12px 14px;
                display: flex;
                flex-direction: column;
                gap: 10px;
                transition: border 0.25s ease, box-shadow 0.25s ease;
            }

            .sidebar-widget-poll .poll-option.is-selected {
                border-color: rgba(9, 89, 171, 0.4);
                box-shadow: 0 12px 24px rgba(9, 89, 171, 0.18);
            }

            .sidebar-widget-poll .poll-option-label {
                display: flex;
                align-items: center;
                gap: 12px;
                cursor: pointer;
            }

            .sidebar-widget-poll .poll-option-label img {
                width: 28px;
                height: 20px;
                object-fit: cover;
                border-radius: 4px;
                box-shadow: 0 6px 12px rgba(15, 23, 42, 0.12);
            }

            .sidebar-widget-poll .poll-option-label span {
                font-size: 15px;
                font-weight: 600;
                color: #0f172a;
            }

            .sidebar-widget-poll .poll-progress {
                background: rgba(9, 89, 171, 0.08);
                border-radius: 999px;
                height: 8px;
                overflow: hidden;
                position: relative;
            }

            .sidebar-widget-poll .poll-progress-bar {
                background: linear-gradient(135deg, #0959ab, #1b74d4);
                border-radius: inherit;
                height: 100%;
                transition: width 0.4s ease;
            }

            .sidebar-widget-poll .poll-progress-meta {
                display: flex;
                justify-content: space-between;
                font-size: 12px;
                color: #475569;
                font-weight: 600;
            }

            .sidebar-widget-poll .poll-submit {
                align-self: flex-start;
                background: #0959ab;
                border: none;
                border-radius: 12px;
                color: #fff;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                font-weight: 600;
                padding: 12px 20px;
                margin-top: 6px;
                cursor: pointer;
                transition: background 0.25s ease, transform 0.25s ease;
            }

            .sidebar-widget-poll .poll-submit:hover {
                background: #0b6fd5;
                transform: translateY(-2px);
            }

            .sidebar-widget-poll .poll-submit:disabled {
                background: rgba(15, 23, 42, 0.25);
                cursor: not-allowed;
                transform: none;
            }

            .sidebar-widget-poll .poll-feedback {
                font-size: 13px;
                color: #0f766e;
                font-weight: 600;
                margin-top: 8px;
                display: none;
            }

            @media (max-width: 600px) {
                .sidebar-widget-poll .poll-card {
                    padding: 18px;
                }

                .sidebar-widget-poll .poll-question {
                    font-size: 17px;
                }

                .sidebar-widget-poll .poll-option-label span {
                    font-size: 14px;
                }
            }
        </style>

        <div class="poll-card" data-poll-widget>
            <div class="poll-meta">
                <h4 class="poll-question">{{ $poll['question'] }}</h4>
                <p class="poll-description">{{ $poll['description'] }}</p>
            </div>

            <form class="poll-form" data-poll-form>
                <div class="poll-options">
                    @foreach($poll['options'] as $option)
                        <label class="poll-option" for="{{ $option['id'] }}">
                            <div class="poll-option-label">
                                <input type="radio" id="{{ $option['id'] }}" name="poll-option" value="{{ $option['label'] }}" hidden>
                                <img src="{{ asset('kcnew/frontend/img/' . $option['flag']) }}" alt="{{ $option['label'] }}">
                                <span>{{ $option['label'] }}</span>
                            </div>
                            <div class="poll-progress">
                                <div class="poll-progress-bar" style="width: {{ $option['percent'] }}%;"></div>
                            </div>
                            <div class="poll-progress-meta">
                                <span>Tỷ lệ ủng hộ</span>
                                <span>{{ $option['percent'] }}%</span>
                            </div>
                        </label>
                    @endforeach
                </div>
                <button class="poll-submit" type="button" data-poll-submit disabled>
                    <i class="fa fa-check-circle"></i> Bình chọn
                </button>
                <div class="poll-feedback" data-poll-feedback>Cảm ơn bạn! Kết quả sẽ được cập nhật sau ít phút.</div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pollWidget = document.querySelector('[data-poll-widget]');
        if (!pollWidget) {
            return;
        }

        const options = pollWidget.querySelectorAll('.poll-option');
        const submitButton = pollWidget.querySelector('[data-poll-submit]');
        const feedback = pollWidget.querySelector('[data-poll-feedback]');

        options.forEach(function (option) {
            option.addEventListener('click', function () {
                options.forEach(function (item) {
                    item.classList.remove('is-selected');
                    const input = item.querySelector('input[type="radio"]');
                    if (input) {
                        input.checked = false;
                    }
                });

                option.classList.add('is-selected');
                const input = option.querySelector('input[type="radio"]');
                if (input) {
                    input.checked = true;
                }

                if (submitButton) {
                    submitButton.disabled = false;
                }
            });
        });

        if (submitButton) {
            submitButton.addEventListener('click', function () {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang gửi...';

                setTimeout(function () {
                    submitButton.innerHTML = '<i class="fa fa-check"></i> Đã bình chọn';
                    if (feedback) {
                        feedback.style.display = 'block';
                    }
                }, 900);
            });
        }
    });
</script>