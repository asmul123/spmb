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
    
    <!-- Custom file input start -->
    <section id="custom-file-input">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Upload Data Pendaftar</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" method="POST" action={{ url('/pendaftars') }} enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mb-1">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="inputGroupFileAddon01"><i data-feather="upload"></i></span>
                                            <div class="form-file">
                                                <input type="file" class="form-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="file">
                                                <label class="form-file-label" for="inputGroupFile01">
                                                    <span class="form-file-text">Pilih Berkas...</span>
                                                    <span class="form-file-button">Jelajahi</span>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1">Kirim</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Custom file input end -->
    <section class="section">
        <div class="card">
            <div class="card-header">
                Data Pendaftar                
                <div class="col-sm-12 d-flex justify-content-end">
                    <a href="{{ url('/pendaftars/1?act=delete') }}" class="btn btn-danger mr-1 mb-1">Hapus</a>
                    <a href="{{ url('/pendaftars/1?act=reset') }}" class="btn btn-warning mr-1 mb-1">Reset</a>
                    <a href="{{ url('/pendaftars/create') }}" class="btn btn-primary mr-1 mb-1">Seleksi</a>
                </div>
            </div>
            <div class="card-body">                
                @if (session('success'))
                <div class="alert alert-light-success color-warning">{{ session('success') }}</div>
                @endif
                <table class='table table-striped' id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jalur</th>
                            <th>Nomor Pendaftaran</th>
                            <th>Nama CMB</th>
                            <th>Asal Sekolah</th>
                            <th>Pilihan 1</th>
                            <th>Pilihan 2</th>
                            <th>Pilihan 3</th>
                            <th>Skor</th>
                            <th>Status</th>
                            <th>Pada Program Keahlian</th>
                            <th>Skor Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendaftars as $pendaftar)
                        @php
                        if(isset($jalurbefore)){
                            if ($pendaftar->jalur == $jalurbefore and $pendaftar->pilihan_diterima == $progbefore) {
                                $no++;
                            } else {
                                $no = 1;
                            }
                        }
                        @endphp
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $pendaftar->jalur }}</td>
                            <td>{{ $pendaftar->nomor_pendaftaran }}</td>
                            <td>{{ $pendaftar->nama }}</td>
                            <td>{{ $pendaftar->asal_sekolah }}</td>
                            <td>{{ $pendaftar->pilihan_1 }}</td>
                            <td>{{ $pendaftar->pilihan_2 }}</td>
                            <td>{{ $pendaftar->pilihan_3 }}</td>
                            <td>{{ "Pilihan 1 : ".$pendaftar->skor_pilihan_1."\nPilihan 2 : ".$pendaftar->skor_pilihan_2."\nPilihan 3 : ".$pendaftar->skor_pilihan_3 }}</td>
                            <td>
                                <span class="badge bg-success">di Pilihan ke : {{ $pendaftar->pilihan_ke }}</span>
                            </td>
                            <td>{{ $pendaftar->pilihan_diterima }}</td>
                            <td>{{ $pendaftar->skor_akhir }}</td>
                        </tr>
                        @php
                            $jalurbefore = $pendaftar->jalur;
                            $progbefore = $pendaftar->pilihan_diterima;
                        @endphp
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
