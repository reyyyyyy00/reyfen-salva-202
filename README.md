 <!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Biodata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .nav-link {
            color: #000080 !important;
            font-weight: bold;
        }

        .tab-content {
            background: white;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }

        label {
            color: gray;
        }

        .centered {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 70vh;
        }

        .card {
            width: 50%;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Biodata</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="tab-content">

            <div class="tab-pane fade show active" id="home">
                <div class="centered">
                    <div class="card shadow">
                        <div class="card-body">
                            <h3 class="text-primary text-center">curriculum vitae</h3>
                            <form>
                                <div class="mb-3 text-center">
                                    <label class="form-label">Foto (3x4):</label><br>
                                    <img src="karina.jpg" alt="Foto Karina" class="img-thumbnail" width="150">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama:</label>
                                    <input type="text" class="form-control" value="Reyfen Salva" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Lahir:</label>
                                    <input type="text" class="form-control" value="27-02-2025" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Alamat:</label>
                                    <input type="text" class="form-control" value="Jogja" readonly>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="contact">
                <h3 class="text-primary">Informasi Formulir</h3>
                <form>
                    <div class="mb-3">
                        <label class="form-label">Email:</label>
                        <input type="email" class="form-control" value="vicidior123@gmail.com" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin:</label><br>
                        <input type="radio" name="gender" checked> Laki-laki
                        <input type="radio" name="gender"> Perempuan
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hobi:</label><br>
                        <input type="checkbox" checked> Basket
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kesan & Pesan:</label>
                        <textarea class="form-control" readonly>Mantab</textarea>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>