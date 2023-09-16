$(document).ready(function() {
    // Inisialisasi data awal
    var kodebarang = $('#kode_barang').val();
    $.ajax({
        type: 'GET',
        url: '/getdatabarang/' + kodebarang,
        dataType: 'json',
        success: function(response) {
            $('#nama_barang').val(response.nama_barang);
            $('#prosesor').val(response.prosesor);
            $('#ram').val(response.ram);
            $('#penyimpanan').val(response.penyimpanan);
            $('#input_status_barang').val(response.status_barang);
            $('#kode_barang_table').val(response.kode_barang_table);

            // Set select box berdasarkan nilai status_barang
            $('#status_barang').val(response.status_barang);
            // Memeriksa status_barang dan mengatur tombol "Lanjut"
            // checkStatus(response.status_barang, response.kode_barang_table);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });

    $('#kode_barang').on('input', function() {
        var kodebarang = $(this).val();
        $.ajax({
            type: 'GET',
            url: '/getdatabarang/' + kodebarang,
            dataType: 'json',
            success: function(response) {
                $('#nama_barang').val(response.nama_barang);
                $('#prosesor').val(response.prosesor);
                $('#ram').val(response.ram);
                $('#penyimpanan').val(response.penyimpanan);
                $('#penyimpanan').val(response.penyimpanan);
                $('#input_status_barang').val(response.status_barang);
                $('#kode_barang_table').val(response.kode_barang_table);

                // Set select box berdasarkan nilai status_barang
                $('#status_barang').val(response.status_barang);

                // Memeriksa status_barang dan mengatur tombol "Lanjut"
                // checkStatus(response.status_barang, response.kode_barang_table);
            },
        });
    });

});


// document.addEventListener('DOMContentLoaded', function() {
//     var textareas = document.querySelectorAll('textarea');

//     textareas.forEach(function(textarea) {
//         textarea.addEventListener('input', function() {
//             var text = textarea.value.toLowerCase();
//             var sentences = text.split('. ');

//             for (var i = 0; i < sentences.length; i++) {
//                 sentences[i] = sentences[i].charAt(0).toUpperCase() + sentences[i].slice(1);
//             }

//             textarea.value = sentences.join('. ');
//         });
//     });
// });