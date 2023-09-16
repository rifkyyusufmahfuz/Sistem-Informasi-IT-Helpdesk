var wrapper2 = document.getElementById("signature-pad2");
var clearButton2 = wrapper2.querySelector("[data-action=hapus_ttd]");
var canvas2 = wrapper2.querySelector("#the_canvas2");
var el_note2 = document.getElementById("note2");
var signaturePad2;
signaturePad2 = new SignaturePad(canvas2, {
    minWidth: 1,
    maxWidth: 1,
});

clearButton2.addEventListener("click", function(event) {
    el_note2.innerHTML = "Silakan tanda tangan di area kolom ini";
    signaturePad2.clear();
});

var form2 = document.getElementById('signature-pad2');
form2.addEventListener('submit', function(event) {
    if (signaturePad2.isEmpty()) {
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Isi tanda tangan terlebih dahulu!',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    } else {
        var dataUrl2 = canvas2.toDataURL();
        document.getElementById("ttd_bast").value = dataUrl2;
    }
});

function my_function2() {
    el_note2.innerHTML = "";
}