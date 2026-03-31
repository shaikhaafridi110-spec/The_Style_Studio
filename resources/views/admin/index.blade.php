@extends('admin.layouts')

@section('user-css')
<link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI';
    }

    body {
        background: #f4f6f9;
    }

    .container {
        display: flex;
    }

    /* SIDEBAR */
  

    .logo {
        margin-bottom: 30px;
        color: #2f4fb3;
    }

    

    /* TOPBAR */
    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .admin {
        font-weight: bold;
    }

    /* CARDS */
    .cards {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    .card {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .card h4 {
        color: #777;
    }

    .card h2 {
        margin-top: 10px;
    }

    /* TABLE */
    .table-box {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th,
    td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
    }

    /* STATUS */
    .status {
        padding: 5px 10px;
        border-radius: 20px;
        color: #fff;
    }

    .success {
        background: green;
    }

    .pending {
        background: orange;
    }

    .danger {
        background: red;
    }
</style>
@endsection

@section('main-content')
<div class="content-wrapper">
   

        

        <!-- MAIN -->
        <main class="main">

            <!-- TOPBAR -->
            <header class="topbar">
                <h3>Dashboard</h3>
                <div class="admin">
                   
                </div>
            </header>

            <!-- CARDS -->
            <div class="cards">

                <div class="card">
                    <h4>Total Users</h4>
                    <h2>120</h2>
                </div>

                <div class="card">
                    <h4>Total Products</h4>
                    <h2>85</h2>
                </div>

                <div class="card">
                    <h4>Total Orders</h4>
                    <h2>56</h2>
                </div>

                <div class="card">
                    <h4>Revenue</h4>
                    <h2>₹45,000</h2>
                </div>

            </div>

            <!-- TABLE -->
            <div class="table-box">
                <h3>Recent Orders</h3>

                <table>
                    <tr>
                        <th>User</th>
                        <th>Product</th>
                        <th>Status</th>
                        <th>Amount</th>
                    </tr>

                    <tr>
                        <td>John</td>
                        <td>T-shirt</td>
                        <td><span class="status success">Delivered</span></td>
                        <td>₹999</td>
                    </tr>

                    <tr>
                        <td>Amit</td>
                        <td>Jeans</td>
                        <td><span class="status pending">Pending</span></td>
                        <td>₹1499</td>
                    </tr>

                </table>
            </div>


            

        </main>


    
</div>
@endsection