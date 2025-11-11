    </div> <!-- Tutup .container -->

    <footer class="footer text-center mt-auto py-3">
      <p>Alat Kesehatan Rumah Sakit Fulan © 2025</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Animasi Hapus + Notifikasi -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Efek animasi saat hapus
      const buttons = document.querySelectorAll('.btn-delete');
      buttons.forEach(btn => {
        btn.addEventListener('click', function() {
          const id = this.getAttribute('data-id');
          const row = this.closest('tr');
          if (confirm('Yakin ingin menghapus data ini?')) {
            row.style.transition = 'opacity 0.5s ease';
            row.style.opacity = '0';
            setTimeout(() => {
              window.location.href = `delete.php?id=${id}`;
            }, 500);
          }
        });
      });

      // Tampilkan notifikasi jika penghapusan berhasil
      const params = new URLSearchParams(window.location.search);
      if (params.get('deleted') === 'true') {
        const alertBox = document.createElement('div');
        alertBox.className = 'alert alert-success position-fixed top-0 end-0 m-3';
        alertBox.textContent = '✅ Data berhasil dihapus!';
        document.body.appendChild(alertBox);
        setTimeout(() => alertBox.remove(), 3000);
      }
    });
    </script>
  </body>
</html>