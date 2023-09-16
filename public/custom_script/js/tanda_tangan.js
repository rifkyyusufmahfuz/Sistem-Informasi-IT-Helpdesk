var wrapper = document.getElementById("signature-pad");
var clearButton = wrapper.querySelector("[data-action=clear]");
var canvas = wrapper.querySelector("canvas");
var el_note = document.getElementById("note");
var signaturePad;
signaturePad = new SignaturePad(canvas, {
    minWidth: 1,
    maxWidth: 1,
});

clearButton.addEventListener("click", function(event) {
    document.getElementById("note").innerHTML = "Silakan tanda tangan di area kolom ini";
    signaturePad.clear();
});

var form = document.getElementById('signature-pad');
form.addEventListener('submit', function(event) {
    if (signaturePad.isEmpty()) {
        // alert("Silakan tanda tangan terlebih dahulu!");
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
        var canvas = document.getElementById("the_canvas");
        var dataUrl = canvas.toDataURL();
        document.getElementById("signature").value = dataUrl;
    }
});

function my_function() {
    document.getElementById("note").innerHTML = "";
}