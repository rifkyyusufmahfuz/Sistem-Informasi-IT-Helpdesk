<!-- Modal -->
@foreach ($permintaan as $data)
    <div class="modal fade" id="modalProses{{ $data->id_permintaan }}" tabindex="-1" role="dialog"
        aria-labelledby="modalProsesLabel{{ $data->id_permintaan }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProsesLabel">Proses Permintaan Instalasi Software</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/admin/crud/{{ $data->id_permintaan }}" method="POST" id="form-update-permintaan">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <label for="status_permintaan">Status Permintaan</label>
                        <select class="form-control" name="status_permintaan" id="status_permintaan">
                            <option value="" disabled>--Status Permintaan--</option>
                            <option value="1" {{ $data->status_permintaan == 1 ? 'selected disabled' : '' }}>
                                Pending
                            </option>
                            <option value="2" {{ $data->status_permintaan == 2 ? 'selected' : '' }}>Menunggu unit
                                diserahkan</option>
                            <option value="3" {{ $data->status_permintaan == 3 ? 'selected' : '' }}>Unit sudah
                                diterima
                            </option>
                            <option value="4" {{ $data->status_permintaan == 4 ? 'selected' : '' }}>Unit siap
                                diambil
                            </option>
                            <option value="5" {{ $data->status_permintaan == 5 ? 'selected' : '' }}>Unit sudah
                                dikembalikan</option>
                        </select>
           
                        <div id="danger-text" class="small alert alert-warning p-1 mt-2 justify-content-between" style="display: none;">Setelah
                            disimpan, opsi ini tidak bisa diubah kembali. Pastikan permintaan sudah selesai dan barang
                            sudah dikembalikan ke requestor!
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script>
    // Mendapatkan elemen select box dan text danger
    const statusPermintaan = document.getElementById('status_permintaan');
    const dangerText = document.getElementById('danger-text');

    // Mendengarkan perubahan pada select box
    statusPermintaan.addEventListener('change', function() {
        // Mengecek apakah nilai select box adalah 5
        if (this.value === '5') {
            // Jika ya, tampilkan text danger
            dangerText.style.display = 'block';
        } else {
            // Jika tidak, sembunyikan text danger
            dangerText.style.display = 'none';
        }
    });
</script>
