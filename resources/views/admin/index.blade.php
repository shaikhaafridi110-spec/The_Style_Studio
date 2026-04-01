@extends('admin.layouts')

@section('user-css')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Playfair+Display:wght@600&display=swap');

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    .ds-root {
        font-family: 'DM Sans', sans-serif;
        background: #f4f2ee;
        color: #1a1a1a;
    }

    /* ── Page header ── */
    .page-title {
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        color: #1a1a2e;
        letter-spacing: 0.3px;
    }

    .page-sub {
        font-size: 13px;
        color: #888;
        margin-top: 2px;
    }

    /* ════════════════════════════════
       SKELETON LOADER
    ════════════════════════════════ */
    @keyframes shimmer {
        0% {
            background-position: -600px 0;
        }

        100% {
            background-position: 600px 0;
        }
    }

    .skeleton {
        background: linear-gradient(90deg, #e8e4de 25%, #f0ece6 50%, #e8e4de 75%);
        background-size: 600px 100%;
        animation: shimmer 1.4s infinite linear;
        border-radius: 8px;
    }

    .skel-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid rgba(0, 0, 0, 0.06);
        height: 118px;
    }

    .skel-chart {
        height: 260px;
        border-radius: 16px;
    }

    .skel-box {
        height: 220px;
        border-radius: 16px;
    }

    #skeletonUI {
        display: block;
    }

    #realContent {
        display: none;
    }

    /* ════════════════════════════════
       STAT CARDS
    ════════════════════════════════ */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }

    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.06);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.1);
    }

    .stat-card .corner-deco {
        position: absolute;
        top: -18px;
        right: -18px;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        opacity: 0.12;
    }

    .stat-card .icon-wrap {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin-bottom: 14px;
    }

    .stat-card .label {
        font-size: 12px;
        color: #888;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .stat-card .value {
        font-size: 28px;
        font-weight: 600;
        line-height: 1;
    }

    .stat-card .sub-row {
        margin-top: 10px;
        font-size: 12px;
        display: flex;
        gap: 12px;
    }

    .sc-blue .corner-deco {
        background: #4e73df;
    }

    .sc-blue .icon-wrap {
        background: #eef1fd;
        color: #4e73df;
    }

    .sc-blue .value {
        color: #4e73df;
    }

    .sc-green .corner-deco {
        background: #1cc88a;
    }

    .sc-green .icon-wrap {
        background: #e8faf4;
        color: #1cc88a;
    }

    .sc-green .value {
        color: #1cc88a;
    }

    .sc-amber .corner-deco {
        background: #f6c23e;
    }

    .sc-amber .icon-wrap {
        background: #fef8e7;
        color: #f6c23e;
    }

    .sc-amber .value {
        color: #e6a800;
    }

    .sc-red .corner-deco {
        background: #e74a3b;
    }

    .sc-red .icon-wrap {
        background: #fdecea;
        color: #e74a3b;
    }

    .sc-red .value {
        color: #e74a3b;
    }

    /* ════════════════════════════════
       DATE RANGE FILTER
    ════════════════════════════════ */
    .chart-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 12px;
    }

    .range-tabs {
        display: flex;
        gap: 4px;
        background: #f4f2ee;
        border-radius: 10px;
        padding: 4px;
    }

    .range-tab {
        font-size: 11px;
        font-weight: 600;
        padding: 5px 13px;
        border-radius: 7px;
        border: none;
        background: transparent;
        color: #888;
        cursor: pointer;
        transition: all 0.18s;
        font-family: 'DM Sans', sans-serif;
        letter-spacing: 0.3px;
    }

    .range-tab:hover {
        color: #1a1a2e;
        background: #eae7e0;
    }

    .range-tab.active {
        background: #fff;
        color: #4e73df;
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.10);
    }

    /* ════════════════════════════════
       TOGGLE LEGEND BUTTONS
    ════════════════════════════════ */
    .chart-legend {
        display: flex;
        gap: 10px;
        margin-bottom: 0;
        flex-wrap: wrap;
    }

    .legend-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: #666;
        background: #f4f2ee;
        border: 1.5px solid transparent;
        border-radius: 8px;
        padding: 5px 12px;
        cursor: pointer;
        transition: all 0.18s;
        font-family: 'DM Sans', sans-serif;
        font-weight: 500;
        user-select: none;
    }

    .legend-btn:hover {
        background: #ece9e3;
    }

    .legend-btn.active-sales {
        background: #eef1fd;
        border-color: #4e73df;
        color: #4e73df;
    }

    .legend-btn.active-orders {
        background: #e8faf4;
        border-color: #1cc88a;
        color: #1cc88a;
    }

    .legend-btn.inactive {
        opacity: 0.45;
        filter: grayscale(0.5);
    }

    .legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 3px;
        flex-shrink: 0;
    }

    /* ════════════════════════════════
       CHARTS / BOXES
    ════════════════════════════════ */
    .charts-row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 16px;
        margin-bottom: 20px;
    }

    .box {
        background: #fff;
        border-radius: 16px;
        padding: 20px 24px;
        border: 1px solid rgba(0, 0, 0, 0.06);
    }

    .box-title {
        font-size: 14px;
        font-weight: 600;
        color: #1a1a2e;
        letter-spacing: 0.2px;
    }

    .full-row {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
        margin-bottom: 20px;
    }

    /* ── Top Products ── */
    .product-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f5f5f5;
        font-size: 13px;
    }

    .product-row:last-child {
        border-bottom: none;
    }

    .product-name {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .product-rank {
        width: 22px;
        height: 22px;
        border-radius: 6px;
        background: #f4f2ee;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 600;
        color: #666;
    }

    .bar-wrap {
        width: 180px;
        height: 7px;
        background: #f0f0f0;
        border-radius: 99px;
        overflow: hidden;
    }

    .bar-fill {
        height: 100%;
        border-radius: 99px;
        transition: width 0.5s ease;
    }

    /* ════════════════════════════════
       ORDERS TABLE + 5 BADGES
    ════════════════════════════════ */
    .orders-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .orders-table th {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #aaa;
        font-weight: 500;
        padding: 0 8px 10px;
        text-align: left;
        border-bottom: 1px solid #f0f0f0;
    }

    .orders-table td {
        padding: 11px 8px;
        border-bottom: 1px solid #f7f7f7;
        color: #333;
    }

    .orders-table tr:last-child td {
        border-bottom: none;
    }

    .orders-table tr:hover td {
        background: #fafaf8;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .badge-success::before {
        background: #1cc88a;
    }

    .badge-success {
        background: #e8faf4;
        color: #0f7a5a;
    }

    .badge-pending::before {
        background: #f6c23e;
    }

    .badge-pending {
        background: #fff4e0;
        color: #b07a00;
    }

    .badge-processing::before {
        background: #4e73df;
    }

    .badge-processing {
        background: #eef1fd;
        color: #3a56b0;
    }

    .badge-shipped::before {
        background: #9b59f5;
    }

    .badge-shipped {
        background: #f0eaff;
        color: #6d35b8;
    }

    .badge-cancelled::before {
        background: #e74a3b;
    }

    .badge-cancelled {
        background: #fdecea;
        color: #b0201a;
    }

    @media (max-width: 900px) {
        .cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .charts-row {
            grid-template-columns: 1fr;
        }

        .bar-wrap {
            width: 100px;
        }

        .chart-header {
            flex-direction: column;
        }
    }
</style>
@endsection


@section('main-content')
<div class="ds-root" style="padding: 28px;">

    <!-- Header -->
    <div style="margin-bottom: 28px;">
        <div class="page-title">Dashboard</div>
        <div class="page-sub">Style Studio Admin Panel</div>
    </div>

    {{-- ════ SKELETON ════ --}}
    <div id="skeletonUI">
        <div class="cards-grid" style="margin-bottom:20px;">
            @for ($s = 0; $s < 4; $s++)
                <div class="skel-card">
                <div class="skeleton" style="width:40px;height:40px;border-radius:10px;margin-bottom:14px;"></div>
                <div class="skeleton" style="height:12px;width:70%;margin-bottom:10px;border-radius:6px;"></div>
                <div class="skeleton" style="height:28px;width:55%;margin-bottom:14px;border-radius:6px;"></div>
                <div class="skeleton" style="height:10px;width:80%;border-radius:6px;"></div>
        </div>
        @endfor
    </div>
    <div style="display:grid;grid-template-columns:2fr 1fr;gap:16px;margin-bottom:20px;">
        <div class="skeleton skel-chart"></div>
        <div class="skeleton skel-box"></div>
    </div>
    <div style="margin-bottom:16px;">
        <div class="skeleton skel-box"></div>
    </div>
    <div>
        <div class="skeleton skel-box"></div>
    </div>
</div>

{{-- ════ REAL CONTENT ════ --}}
<div id="realContent">

    <!-- Stat Cards -->
    <div class="cards-grid">

        <div class="stat-card sc-blue">
            <div class="corner-deco"></div>
            <div class="icon-wrap"><i class="mdi mdi-account" style="font-size:20px;"></i></div>
            <div class="label">Total Users</div>
            <div class="value" data-target="{{ $user }}" data-prefix="">0</div>
            <div class="sub-row"><span style="color:#4e73df;">Registered accounts</span></div>
        </div>

        <div class="stat-card sc-green">
            <div class="corner-deco"></div>
            <div class="icon-wrap"><i class="mdi mdi-tshirt-crew" style="font-size:20px;"></i></div>
            <div class="label">Products</div>
            <div class="value" data-target="{{ $product }}" data-prefix="">0</div>
            <div class="sub-row"><span style="color:#1cc88a;">Live in store</span></div>
        </div>

        <div class="stat-card sc-amber">
            <div class="corner-deco"></div>
            <div class="icon-wrap"><i class="mdi mdi-cart-outline" style="font-size:20px;"></i></div>
            <div class="label">Orders</div>
            <div class="value" data-target="{{ $order }}" data-prefix="">0</div>
            <div class="sub-row">
                <span style="color:#0f7a5a;">✔ {{ $delivered}} delivered</span>
                <span style="color:#b07a00;">⏳ {{ $pending }} pending</span>
            </div>
        </div>

        <div class="stat-card sc-red">
            <div class="corner-deco"></div>
            <div class="icon-wrap"><i class="mdi mdi-currency-inr" style="font-size:20px;"></i></div>
            <div class="label">Revenue</div>
            <div class="value" data-target="{{$revenue}}" data-prefix="₹"></div>
            <div class="sub-row"><span style="color:#e74a3b;">Total collected</span></div>
        </div>

    </div>

    <!-- Charts -->
    <div class="charts-row">

        <div class="box">
            <div class="chart-header">
                <div>
                    <div class="box-title" style="margin-bottom:10px;">Sales Overview</div>
                    <div class="chart-legend">
                        <button class="legend-btn active-sales" id="btnSales" onclick="toggleDataset('sales')">
                            <div class="legend-dot" style="background:#4e73df;"></div> Sales ₹
                        </button>
                        <button class="legend-btn active-orders" id="btnOrders" onclick="toggleDataset('orders')">
                            <div class="legend-dot" style="background:#1cc88a;"></div> Orders
                        </button>
                    </div>
                </div>
                <div class="range-tabs">
                    <button class="range-tab" onclick="setRange('today',this)">Today</button>
                    <button class="range-tab active" onclick="setRange('week',this)">Week</button>
                    <button class="range-tab" onclick="setRange('month',this)">Month</button>
                    <button class="range-tab" onclick="setRange('year',this)">Year</button>
                </div>
            </div>
            <div style="position:relative; height:220px;">
                <canvas id="chart1"></canvas>
            </div>
        </div>

        <div class="box">
            <div class="box-title" style="margin-bottom:16px;">Conversion Rate</div>
            <div style="position:relative; height:220px;">
                <canvas id="chart2"></canvas>
            </div>
        </div>

    </div>

    <!-- Top Products -->
    <div class="full-row">
        <div class="box">
            <div class="box-title" style="margin-bottom:16px;">Top Products</div>
            <div id="topProducts">
                @foreach($topProducts as $index => $p)
                <div class="product-row">
                    <div class="product-name">
                        <div class="product-rank">{{ $index+1 }}</div>
                        <span>{{ $p->product_name }}</span>
                    </div>

                    <div style="display:flex;align-items:center;gap:12px;">
                        <div class="bar-wrap">
                            <div class="bar-fill" style="width: {{ $p->total }}%; background:#4e73df;"></div>
                        </div>
                        <span>{{ $p->total }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="full-row">
        <div class="box">
            <div class="box-title" style="margin-bottom:16px;">Recent Orders</div>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $o)
                    <tr>
                        <td>#{{ $o->id }}</td>
                        <td>{{ $o->name }}</td>
                        <td>₹{{ $o->final_amount }}</td>
                        <td>
                            <span class="badge 
    @if($o->status == 'delivered') badge-success
    @elseif($o->status == 'pending') badge-pending
    @elseif($o->status == 'confirmed') badge-processing
    @elseif($o->status == 'shipped') badge-shipped
    @elseif($o->status == 'cancelled') badge-cancelled
    @endif
">
    {{ ucfirst($o->status) }}
</span>
                        </td>
                        <td>{{ date('d M Y', strtotime($o->created_at)) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    /* ── Chart data per range ── */

   

    const labels = @json($days);
    const sales = @json($sales);
    const orders = @json($orders);
    const conversion = @json($conversion);

    /* ── Chart 1: Sales Overview ── */
    const chart1 = new Chart(document.getElementById('chart1'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Sales ₹',
                data: sales,
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78,115,223,0.08)',
                fill: true,
                yAxisID: 'y'
            },
            {
                label: 'Orders',
                data: orders,
                borderColor: '#1cc88a',
                backgroundColor: 'transparent',
                yAxisID: 'y1'   // ✅ RIGHT SIDE
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                position: 'left',
                title: {
                    display: true,
                    text: 'Sales ₹'
                }
            },
            y1: {
                position: 'right',   // ✅ RIGHT SIDE AXIS
                grid: {
                    drawOnChartArea: false   // ✅ clean UI
                },
                title: {
                    display: true,
                    text: 'Orders'
                }
            }
        }
    }
});

    /* ── Chart 2: Conversion Rate ── */
    const chart2 = new Chart(document.getElementById('chart2'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Conversion %',
                data: conversion,
                backgroundColor: '#c9a97a'
            }]
        },
        options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
        y: { position: 'left' },
        y1: {
            position: 'right',
            grid: { drawOnChartArea: false }
        }
    }
}
    });
    /* ── Date range switcher ── */
    function setRange(range, btn) {

    document.querySelectorAll('.range-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    // ======================
    // TODAY
    // ======================
    if (range === 'today') {

        chart1.data.labels = @json($todayLabels);
        chart1.data.datasets[0].data = @json($todaySales);
        chart1.data.datasets[1].data = @json($todayOrders);

        chart2.data.labels = @json($todayLabels);
        chart2.data.datasets[0].data = @json($todayConversion);
    }

    // ======================
    // WEEK
    // ======================
    else if (range === 'week') {

        chart1.data.labels = @json($days);
        chart1.data.datasets[0].data = @json($sales);
        chart1.data.datasets[1].data = @json($orders);

        chart2.data.labels = @json($days);
        chart2.data.datasets[0].data = @json($conversion);
    }

    // ======================
    // MONTH
    // ======================
    else if (range === 'month') {

        chart1.data.labels = @json($monthLabels);
        chart1.data.datasets[0].data = @json($monthSales);
        chart1.data.datasets[1].data = @json($monthOrders);

        chart2.data.labels = @json($monthLabels);
        chart2.data.datasets[0].data = @json($monthConversion);
    }

    // ======================
    // YEAR
    // ======================
    else if (range === 'year') {

        chart1.data.labels = @json($yearLabels);
        chart1.data.datasets[0].data = @json($yearSales);
        chart1.data.datasets[1].data = @json($yearOrders);

        chart2.data.labels = @json($yearLabels);
        chart2.data.datasets[0].data = @json($yearConversion);
    }

    chart1.update();
    chart2.update();
}

    /* ── Series toggle ── */
    const toggleState = {
        sales: true,
        orders: true
    };

    function toggleDataset(which) {
        toggleState[which] = !toggleState[which];
        chart1.getDatasetMeta(which === 'sales' ? 0 : 1).hidden = !toggleState[which];
        chart1.update();
        const btnS = document.getElementById('btnSales');
        const btnO = document.getElementById('btnOrders');
        btnS.className = 'legend-btn' + (toggleState.sales ? ' active-sales' : ' inactive');
        btnO.className = 'legend-btn' + (toggleState.orders ? ' active-orders' : ' inactive');
    }

    /* ── Top Products ── */


    /* ── Recent Orders (5 statuses) ── */


    /* ── Animated counters ── */
    function animateCounter(el) {
        const target = parseInt(el.dataset.target, 10);
        const prefix = el.dataset.prefix || '';
        const duration = 1200;
        const start = performance.now();
        (function step(now) {
            const p = Math.min((now - start) / duration, 1);
            const e = 1 - Math.pow(1 - p, 3); // ease-out cubic
            el.textContent = prefix + Math.floor(e * target).toLocaleString('en-IN');
            if (p < 1) requestAnimationFrame(step);
        })(start);
    }

    /* ── Skeleton → Real (simulates 900ms network fetch) ── */
    window.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {

            document.getElementById('skeletonUI').style.display = 'none';
            document.getElementById('realContent').style.display = 'block';

            // FIX: Resize charts after showing
            chart1.resize();
            chart2.resize();

            chart1.update();
            chart2.update();

            document.querySelectorAll('.stat-card .value[data-target]').forEach(animateCounter);

        }, 900);
    });
</script>
@endsection