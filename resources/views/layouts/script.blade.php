<!-- Bootstrap core JavaScript-->
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}

<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
</script>


{{-- End Of Custom Script --}}

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Styles -->

<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

{{-- KHUSUS SCRIPT BARU TARO DI BAWAH INI --}}
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
@include('sweetalert::alert')



{{-- custom script --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script> --}}

<script src="{{ asset('custom_script/js/cari_data_pegawai.js') }}"></script>
<script src="{{ asset('custom_script/js/cari_data_barang.js') }}"></script>
<script src="{{ asset('custom_script/js/fungsi_tombol.js') }}"></script>
<script src="{{ asset('custom_script/js/tanda_tangan.js') }}"></script>
<script src="{{ asset('custom_script/js/tanda_tangan_bast.js') }}"></script>


{{-- untuk grafik dashboard --}}
<script src="{{ asset('custom_script/js/dashboard_manager/dashboard_manager.js') }}"></script>

<!-- Tambahkan ini pada bagian bawah halaman atau di bagian footer -->
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}



<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
{{-- end of custom script  --}}
