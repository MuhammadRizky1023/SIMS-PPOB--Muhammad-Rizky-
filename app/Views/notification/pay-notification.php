<!-- SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Tidak perlu fungsi setAmount untuk pembayaran

function formatRupiah(angka) {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency', currency: 'IDR', minimumFractionDigits: 0
  }).format(angka);
}

function confirmPayment() {
  const serviceCode = document.getElementById('service_code').value.trim();
  const priceField = document.getElementById('service_price');

  // Asumsi harga sudah diinput atau tampil di readonly field
  const amount = priceField ? parseInt(priceField.value.replace(/[^\d]/g, '')) : 0;

  if (!serviceCode) {
    Swal.fire('Oops', 'Masukkan Kode Layanan terlebih dahulu!', 'warning');
    return;
  }

  Swal.fire({
    title: 'Konfirmasi Pembayaran',
    html: `Anda akan membayar sebesar <strong>${formatRupiah(amount)}</strong> untuk layanan <strong>${serviceCode}</strong>.`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, Bayar Sekarang',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#d33',
    cancelButtonColor: '#aaa',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('paymentForm').submit();
    }
  });
}
</script>
