<!-- resources/views/landing.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Header -->
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3">Nama Perusahaan</h1>
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a href="#home" class="nav-link text-white">Home</a></li>
                    <li class="nav-item"><a href="#features" class="nav-link text-white">Features</a></li>
                    <li class="nav-item"><a href="#contact" class="nav-link text-white">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="bg-primary text-white text-center py-5">
        <div class="container">
            <h2 class="display-4 mb-4">Selamat Datang di Landing Page Kami</h2>
            <p class="lead mb-4">Deskripsi singkat tentang produk atau layanan Anda.</p>
            <a href="#contact" class="btn btn-light">Hubungi Kami</a>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container text-center">
            <h2 class="mb-5">Fitur Utama</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Fitur 1</h5>
                            <p class="card-text">Deskripsi singkat fitur 1.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Fitur 2</h5>
                            <p class="card-text">Deskripsi singkat fitur 2.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Fitur 3</h5>
                            <p class="card-text">Deskripsi singkat fitur 3.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="bg-dark text-white text-center py-5">
        <div class="container">
            <h2 class="mb-4">Hubungi Kami</h2>
            <form action="#" method="POST" class="w-75 mx-auto">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Pesan:</label>
                    <textarea id="message" name="message" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <div class="container">
            <p>&copy; 2024 Nama Perusahaan. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
