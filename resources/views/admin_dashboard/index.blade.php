@extends("admin_dashboard.layouts.app")
@section("style")
    <link href="{{ asset('admin_dashboard_assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
    <style>
        :root {
            --dashboard-primary: #0f172a;
            --dashboard-muted: #64748b;
            --dashboard-blue: #2c85df;
            --dashboard-blue-dark: #0959ab;
            --dashboard-rose: #e63270;
            --dashboard-rose-dark: #b4234c;
            --dashboard-teal: #2dd4bf;
            --dashboard-teal-dark: #0f766e;
            --dashboard-amber: #f59e0b;
            --dashboard-amber-dark: #c46a17;
        }

        .dashboard-stat {
            border: none;
            border-radius: 20px;
            background: linear-gradient(150deg, rgba(255, 255, 255, 0.98) 0%, #f4f8ff 100%);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .dashboard-stat:hover {
            transform: translateY(-4px);
            box-shadow: 0 26px 52px rgba(15, 23, 42, 0.11);
        }

        .dashboard-stat .stat-label {
            margin-bottom: 6px;
            font-size: 15px;
            color: var(--dashboard-muted);
            letter-spacing: .01em;
        }

        .dashboard-stat .stat-value {
            margin: 4px 0 0;
            font-size: 32px;
            font-weight: 700;
            color: var(--dashboard-primary);
        }

        .dashboard-stat .widgets-icons-2 {
            width: 62px;
            height: 62px;
            border-radius: 16px;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.15);
        }

        .dashboard-stat--posts {
            border-left: 5px solid var(--dashboard-blue);
        }

        .dashboard-stat--posts .stat-value {
            color: var(--dashboard-blue-dark);
        }

        .dashboard-stat--posts .widgets-icons-2 {
            background: linear-gradient(150deg, rgba(44, 133, 223, 0.18) 0%, rgba(9, 89, 171, 0.45) 100%);
            color: var(--dashboard-blue-dark);
        }

        .dashboard-stat--categories {
            border-left: 5px solid var(--dashboard-rose);
        }

        .dashboard-stat--categories .stat-value {
            color: var(--dashboard-rose-dark);
        }

        .dashboard-stat--categories .widgets-icons-2 {
            background: linear-gradient(150deg, rgba(230, 50, 112, 0.15) 0%, rgba(180, 35, 76, 0.4) 100%);
            color: var(--dashboard-rose-dark);
        }

        .dashboard-stat--admins {
            border-left: 5px solid var(--dashboard-teal-dark);
        }

        .dashboard-stat--admins .stat-value {
            color: var(--dashboard-teal-dark);
        }

        .dashboard-stat--admins .widgets-icons-2 {
            background: linear-gradient(150deg, rgba(45, 212, 191, 0.22) 0%, rgba(15, 118, 110, 0.45) 100%);
            color: var(--dashboard-teal-dark);
        }

        .dashboard-stat--users {
            border-left: 5px solid var(--dashboard-amber-dark);
        }

        .dashboard-stat--users .stat-value {
            color: var(--dashboard-amber-dark);
        }

        .dashboard-stat--users .widgets-icons-2 {
            background: linear-gradient(150deg, rgba(245, 158, 11, 0.18) 0%, rgba(196, 106, 23, 0.45) 100%);
            color: var(--dashboard-amber-dark);
        }

        .dashboard-side-card {
            border: none;
            border-radius: 20px;
            background: linear-gradient(150deg, rgba(255, 255, 255, 0.98) 0%, #f6f9ff 100%);
            box-shadow: 0 18px 38px rgba(15, 23, 42, 0.08);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            margin-bottom: 22px;
        }

        .dashboard-side-wrapper {
            background: transparent;
            border: none;
            box-shadow: none;
        }

        .dashboard-side-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 24px 50px rgba(15, 23, 42, 0.12);
        }

        .dashboard-side-card .stat-label {
            margin-bottom: 6px;
            font-size: 15px;
            color: var(--dashboard-muted);
            letter-spacing: .01em;
        }

        .dashboard-side-card .stat-value {
            margin: 4px 0 0;
            font-size: 30px;
            font-weight: 700;
            color: var(--dashboard-primary);
        }

        .dashboard-side-card .widgets-icons-2 {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.14);
        }

        .dashboard-side-card--views .widgets-icons-2 {
            background: linear-gradient(150deg, rgba(44, 133, 223, 0.18) 0%, rgba(9, 89, 171, 0.45) 100%);
            color: var(--dashboard-blue-dark);
        }

        .dashboard-side-card--comments .widgets-icons-2 {
            background: linear-gradient(150deg, rgba(230, 50, 112, 0.15) 0%, rgba(180, 35, 76, 0.4) 100%);
            color: var(--dashboard-rose-dark);
        }

        .dashboard-side-card--likes .widgets-icons-2 {
            background: linear-gradient(150deg, rgba(245, 158, 11, 0.18) 0%, rgba(196, 106, 23, 0.45) 100%);
            color: var(--dashboard-amber-dark);
        }

        .dashboard-side-card .stat-pending {
            margin: 4px 0 0;
            font-size: 16px;
            color: #94a3b8;
        }
    </style>
@endsection

@section("wrapper")
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                <div class="col">
                    <div class="card dashboard-stat dashboard-stat--posts">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="stat-label">Tổng bài viết</p>
                                    <h4 class="stat-value">{{ $countPost }}</h4>
                                    <!-- <p class="mb-0 font-13">+2.5% from last week</p> -->
                                </div>
                                <div class="widgets-icons-2 ms-auto"><i class='bx bx-message-square-edit'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card dashboard-stat dashboard-stat--categories">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="stat-label">Tổng danh mục</p>
                                    <h4 class="stat-value">{{ $countCategories }}</h4>
                                </div>
                                <div class="widgets-icons-2 ms-auto"><i class='bx bx bx-menu'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card dashboard-stat dashboard-stat--admins">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="stat-label">Tổng người quản trị</p>
                                    <h4 class="stat-value">{{ $countAdmin }}</h4>
                                </div>
                                <div class="widgets-icons-2 ms-auto"><i class='bx bx-user'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card dashboard-stat dashboard-stat--users">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="stat-label">Tổng khách hàng</p>
                                    <h4 class="stat-value">{{ $countUser }}</h4>
                                </div>
                                <div class="widgets-icons-2 ms-auto"><i class='bx bxs-group'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end row-->

            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Biểu đồ lượt xem</h6>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="d-flex align-items-center ms-auto font-13 gap-2 my-3">
                                <span class="border px-2 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #2c85df"></i>Số người đã đọc</span>
                                <span class="border px-2 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #e63270"></i>Số người đã bình luận</span>
                            </div>
                            <div class="chart-container-1">
                                <canvas id="chart1"></canvas>
                            </div>
                        </div>
                        <div class="row row-cols-1 row-cols-md-3 row-cols-xl-3 g-0 row-group text-center border-top">
                            <div class="col">
                                <div class="p-3">
                                    <h5 class="mb-0">24.15M</h5>
                                    <small class="mb-0">Overall Visitor <span> <i class="bx bx-up-arrow-alt align-middle"></i> 2.43%</span></small>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-3">
                                    <h5 class="mb-0">12:38</h5>
                                    <small class="mb-0">Visitor Duration <span> <i class="bx bx-up-arrow-alt align-middle"></i> 12.65%</span></small>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-3">
                                    <h5 class="mb-0">639.82</h5>
                                    <small class="mb-0">Pages/Visit <span> <i class="bx bx-up-arrow-alt align-middle"></i> 5.62%</span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col-12 col-lg-4 d-flex">
                    <div class="card w-100 dashboard-side-wrapper">
                        <div class="card-body">
                            <div class="card dashboard-side-card dashboard-side-card--views">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="stat-label">Lượt xem</p>
                                            <h4 class="stat-value">{{ $countView }}</h4>
                                            <!-- <p class="mb-0 font-13">+6.2% from last week</p> -->
                                        </div>
                                        <div class="widgets-icons-2 ms-auto"><i class='bx bx-show'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card dashboard-side-card dashboard-side-card--comments">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="stat-label">Bình luận</p>
                                            <h4 class="stat-value">{{ $countComments }}</h4>
                                        </div>
                                        <div class="widgets-icons-2 ms-auto"><i class='bx bxs-comment-detail'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card dashboard-side-card dashboard-side-card--likes mb-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="stat-label">Lượt thích</p>
                                            <p class="stat-pending">Chờ cập nhật...</p>
                                        </div>
                                        <div class="widgets-icons-2 ms-auto"><i class='bx bxs-like'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>

                    </div>

                </div>
            </div><!--end row-->

        </div>
    </div>
@endsection

@section("script")
    <script src="{{ asset('admin_dashboard_assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('admin_dashboard_assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('admin_dashboard_assets/plugins/chartjs/js/Chart.min.js') }}"></script>
    <script src="{{ asset('admin_dashboard_assets/plugins/chartjs/js/Chart.extension.js') }}"></script>
    <script src="{{ asset('admin_dashboard_assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
    <script src="{{ asset('admin_dashboard_assets/js/index.js') }}"></script>

   
	<script>
		$(document).ready(function () {
			// Biểu đồ
        var ctx = document.getElementById("chart1").getContext('2d');
        
		var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
        gradientStroke1.addColorStop(0, '#2c85df');  
        gradientStroke1.addColorStop(1, '#0959ab'); 
		
		var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
        gradientStroke2.addColorStop(0, '#e63270');
        gradientStroke2.addColorStop(1, '#b4234c');
        
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                labels: ['16/06/2022', '17/06/2022', '18/06/2022', '19/06/2022', '20/06/2022', '21/06/2022', '22/06/2022'],
                datasets: [{
                    label: 'Lượt xem',
                    data: [ 10, 13, 9,16, 10, 12,15],
                    borderColor: gradientStroke1,
                    backgroundColor: gradientStroke1,
                    hoverBackgroundColor: gradientStroke1,
                    pointRadius: 0,
                    fill: false,
                    borderWidth: 0
                }, {
                    label: 'Bình luận',
                    data: [ 8, 14, 19, 12, 7, 18, 8],
                    borderColor: gradientStroke2,
                    backgroundColor: gradientStroke2,
                    hoverBackgroundColor: gradientStroke2,
                    pointRadius: 0,
                    fill: false,
                    borderWidth: 0
                }]
                },
                
                options:{
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                    display: false,
                    labels: {
                        boxWidth:8
                    }
                    },
                    tooltips: {
                    displayColors:false,
                    },	
                scales: {
                    xAxes: [{
                        barPercentage: .5
                    }]
                    }
                }
            });
                });

	</script>


@endsection
