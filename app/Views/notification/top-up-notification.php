<!-- SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function setAmount(amount) {
  document.getElementById('top_up_amount').value = amount;
}

function formatRupiah(angka) {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency', currency: 'IDR', minimumFractionDigits: 0
  }).format(angka);
}

function confirmTopup() {
  const amount = parseInt(document.getElementById('top_up_amount').value);

  if (!amount || amount <= 0) {
    Swal.fire('Oops', 'Masukkan nominal Top Up yang valid!', 'warning');
    return;
  }

  Swal.fire({
    title: 'Konfirmasi Top Up',
    html: `<strong>${formatRupiah(amount)}</strong><br>Apakah Anda yakin ingin Top Up sebesar ini?`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, Top Up Sekarang',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#d33',
    cancelButtonColor: '#aaa',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('topupForm').submit();
    }
  });
}
</script>
