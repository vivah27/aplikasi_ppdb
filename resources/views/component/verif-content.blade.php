<div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-sm-12">
        <div class="card construction-card">
            <div class="card-body">
                <div class="construction-image-block">
                    <div class="row justify-content-center">
                        <div class="col-md-5 col-10">
                            <img class="img-fluid" src="assets\images\my\verified.png" alt="img">
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <h1 class="mt-4"><b>Harap verifikasi email Anda terlebih dahulu</b></h1>
                    <p class="mt-4 text-muted">
                        Sebelum melanjutkan, periksa kotak masuk email Anda dan klik tautan verifikasi. Jika tidak
                        menerima email, cek folder spam atau kirim ulang tautan verifikasi.
                    </p>



                    <a href="{{ route('verify.form') }}" id="verify-button"
                        class="btn btn-warning btn-sm fw-bold">Verifikasi
                        Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</div>
