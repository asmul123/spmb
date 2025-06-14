<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPMB 2025 - SMKN 1 GARUT</title>
    
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    
<link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
</head>
<body>
    <div id="app">
        <div id="sidebar" class='active'>
            <div class="sidebar-wrapper active">
    <div class="sidebar-header">
        <img src="assets/images/logo.svg" alt="" srcset="">
    </div>
    <div class="sidebar-menu">
        <ul class="menu">
            
            
                <li class='sidebar-title'>Main Menu</li>
            
            
            
                <li class="sidebar-item">
                    <a href="/" class='sidebar-link'>
                        <i data-feather="home" width="20"></i> 
                        <span>Dashboard</span>
                    </a>
                    
                </li>
                
                
                
                
                <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="triangle" width="20"></i> 
                        <span>DATA SPMB</span>
                    </a>
                    
                    <ul class="submenu ">
                        
                        <li>
                            <a href="{{ url('/pendaftars') }}">Data Pendaftar</a>
                        </li>
                        
                        <li>
                            <a href="#">Program Keahlian</a>
                        </li>
                        
                        <li>
                            <a href="{{ url('/kuotas') }}">Kuota</a>
                        </li>
                        
                        
                    </ul>
                    
                </li>          
                
                    <li class="sidebar-item">
                        <a href="/" class='sidebar-link'>
                            <i data-feather="log-out" width="20"></i> 
                            <span>Keluar</span>
                        </a>
                        
                    </li>
            
         
        </ul>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
</div>
        </div>
        <div id="main">
            <nav class="navbar navbar-header navbar-expand navbar-light">
                <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
                <button class="btn navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav d-flex align-items-center navbar-light ml-auto">
                        <li class="dropdown nav-icon">
                            <a href="#" data-toggle="dropdown" class="nav-link  dropdown-toggle nav-link-lg nav-link-user">
                                <div class="d-lg-inline-block">
                                    <i data-feather="bell"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-large">
                                <h6 class='py-2 px-4'>Notifications</h6>
                                <ul class="list-group rounded-none">
                                    <li class="list-group-item border-0 align-items-start">
                                        <div class="avatar bg-success mr-3">
                                            <span class="avatar-content"><i data-feather="shopping-cart"></i></span>
                                        </div>
                                        <div>
                                            <h6 class='text-bold'>New Order</h6>
                                            <p class='text-xs'>
                                                An order made by Ahmad Saugi for product Samsung Galaxy S69
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="dropdown nav-icon mr-2">
                            <a href="#" data-toggle="dropdown" class="nav-link  dropdown-toggle nav-link-lg nav-link-user">
                                <div class="d-lg-inline-block">
                                    <i data-feather="mail"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i data-feather="user"></i> Account</a>
                                <a class="dropdown-item active" href="#"><i data-feather="mail"></i> Messages</a>
                                <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"><i data-feather="log-out"></i> Logout</a>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <div class="avatar mr-1">
                                    <img src="assets/images/avatar/avatar-s-1.png" alt="" srcset="">
                                </div>
                                <div class="d-none d-md-block d-lg-inline-block">Hi, Saugi</div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i data-feather="user"></i> Account</a>
                                <a class="dropdown-item active" href="#"><i data-feather="mail"></i> Messages</a>
                                <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"><i data-feather="log-out"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            
<div class="main-content container-fluid">
    
    <!-- Custom file input end -->
    <section class="section">
        <div class="card">
            <div class="card-header">
                Data Kuota
            </div>
            <div class="card-body">
                <table class='table table-striped' id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jalur</th>
                            <th>Program Keahlian</th>
                            <th>Kuota Asal</th>
                            <th>Kuota Pelimpahan</th>
                            <th>Pendaftar Pilihan 1</th>
                            <th>Jumlah Diterima</th>
                            <th>Passing Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kuotas as $kuota)
                        @php                        
                            if($kuota->model_seleksi == 1){
                                $rank_by = 'desc';
                            } else {
                                $rank_by = 'asc';
                            }
                            $pilihan_1 = App\Models\Pendaftar::where('jalur', $kuota->jalur)->where('pilihan_1', $kuota->program_keahlian)->count();
                            $pendaftar = App\Models\Pendaftar::where('jalur', $kuota->jalur)->where('pilihan_diterima', $kuota->program_keahlian)->orderBy('skor_akhir', $rank_by);
                            $jumlah_pendaftar = $pendaftar->count();
                            if($jumlah_pendaftar != 0){
                                $pg = $pendaftar->first()->skor_akhir;
                            } else {
                                $pg = "-";
                            }
                        @endphp
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $kuota->jalur }}</td>
                            <td>{{ $kuota->program_keahlian }}</td>
                            <td>{{ $kuota->kuota }}</td>
                            <td>{{ $kuota->kuota_pelimpahan }}</td>
                            <td>{{ $pilihan_1 }}</td>
                            <td>{{ $jumlah_pendaftar }}</td>
                            <td>{{ $pg }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-left">
                        <p>2020 &copy; Voler</p>
                    </div>
                    <div class="float-right">
                        <p>Crafted with <span class='text-danger'><i data-feather="heart"></i></span> by <a href="http://ahmadsaugi.com">Ahmad Saugi</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="assets/js/feather-icons/feather.min.js"></script>
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/app.js"></script>
    
<script src="assets/vendors/simple-datatables/simple-datatables.js"></script>
<script src="assets/js/vendors.js"></script>

    <script src="assets/js/main.js"></script>
</body>
</html>
