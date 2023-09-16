let pollingInterval = 30000; // Initial polling interval of 30 seconds

function getNotifications() {
    fetch('/notifications')
        .then(response => response.json())
        .then(data => {
            if (data.notifikasi) {
                // update notification count
                let notifCounter = document.querySelector('#alertsDropdown .badge-counter');
                if (data.totalnotifikasi === 0) {
                    // hide notification count
                    notifCounter.style.display = 'none';
                } else {
                    // show notification count
                    notifCounter.textContent = data.totalnotifikasi;
                    notifCounter.style.display = 'block';
                }

                // remove existing notification items
                let notifList = document.querySelector('#notifications');
                notifList.innerHTML = '';

                // add new notification items
                data.notifikasi.forEach((notif, index) => {
                    // create notification item
                    let item = document.createElement('a');
                    item.classList.add('dropdown-item', 'd-flex', 'align-items-center');
                    item.setAttribute('data-id', notif.id_notifikasi);
                    item.href = notif.tautan;
                    // add click event listener to remove notification
                    item.addEventListener('click', function(e) {
                        // e.preventDefault();
                        read_notifikasi(notif.id_notifikasi);
                        getNotifications();
                    });

                    let icon = document.createElement('div');
                    icon.classList.add('mr-3');
                    let circle = document.createElement('div');
                    circle.classList.add('icon-circle', 'bg-primary');
                    let iconText = document.createElement('i');
                    iconText.classList.add('fas', 'fa-exclamation', 'text-white');
                    circle.appendChild(iconText);
                    icon.appendChild(circle);
                    item.appendChild(icon);

                    // create notification content
                    let content = document.createElement('div');
                    let contentSmall = document.createElement('div');
                    contentSmall.classList.add('small', 'text-gray-500');
                    let date = new Date(notif.created_at);
                    contentSmall.textContent = date.toLocaleString('id-ID');
                    content.appendChild(contentSmall);
                    let contentBold = document.createElement('span');
                    contentBold.classList.add('font-weight-bold');
                    contentBold.classList.add('text-justify');

                    if (notif.read_at === null) {
                        // hide notification count
                        contentBold.classList.add('font-weight-bold');
                    } else {
                        // show notification count
                        contentBold.classList.remove('font-weight-bold');
                    }

                    contentBold.textContent = notif.pesan;
                    content.appendChild(contentBold);
                    item.appendChild(content);

                    // aksi untuk menjalankan fungsi read_all_notifikasi()
                    let read_all = document.querySelector('#read_all_notifikasi');
                    read_all.addEventListener('click', function(e) {
                        read_all_notifikasi();
                        getNotifications();
                        e.preventDefault();
                    });

                    // add delete button
                    let deleteButton = document.createElement('button');
                    deleteButton.classList.add('btn', 'btn-link', 'text-danger', 'ml-auto', 'p-0');
                    deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
                    deleteButton.addEventListener('click', function(e) {
                        e.preventDefault();

                        const KonfirmasiHapus = Swal.mixin({
                            toast: true,
                            position: 'top',
                            showConfirmButton: true,

                            timerProgressBar: true,
                            onOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });

                        // menampilkan sweetalert sebagai konfirmasi hapus
                        const Alert_hapus = Swal.mixin({
                            toast: true,
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });

                        KonfirmasiHapus.fire({
                            icon: 'warning',
                            title: 'Hapus notifikasi ini ?',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, hapus',
                            cancelButtonText: 'Batal',
                            reverseButtons: true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                HapusNotifikasi(notif.id_notifikasi);
                                item.remove();
                                getNotifications();
                                // menampilkan toast sebagai konfirmasi hapus
                                Alert_hapus.fire({
                                    icon: 'success',
                                    title: 'Notifikasi dihapus!'
                                });
                            } else {
                                // tampilkan pesan bahwa penghapusan dibatalkan
                                Alert_hapus.fire({
                                    icon: 'info',
                                    title: 'Penghapusan dibatalkan!'
                                });
                            }
                        });
                    });

                    item.appendChild(deleteButton);

                    notifList.appendChild(item);
                });

                if (data.notifikasi.length > 0) {
                    pollingInterval = 10000; // Set shorter interval if there are new notifications
                } else {
                    pollingInterval = 30000; // Set longer interval if no new notifications
                }
            }
            if (data.notifikasi.length == 0) {
                // if there are no notifications, remove existing items
                let notifCounter = document.querySelector('#alertsDropdown .badge-counter');
                notifCounter.textContent = '';
                let notifList = document.querySelector('#notifications');
                notifList.innerHTML =
                    '<div class="dropdown-item py-3 text-center">Tidak ada notifikasi baru</div>';
            }
        })
        .catch(error => console.log(error));
}

//fungsi untuk hapus notifikasi berdasarkan id notifikasi
function HapusNotifikasi(id_notifikasi) {
    fetch(`/notifikasi/hapus/${id_notifikasi}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
        })
        .catch(error => console.log(error));
}

//fungsi untuk menandai notifikasi telah dibaca berdasarkan id notifikasi
function read_notifikasi(id_notifikasi) {
    fetch(`/notifikasi/read/${id_notifikasi}`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
        })
        .catch(error => console.log(error));
}


// fungsi untuk menandai semua notifikasi telah dibaca
function read_all_notifikasi() {
    let read_all = document.querySelector('#read_all_notifikasi');
    let id = read_all.dataset.id;

    if (id === '1' || id === '2' || id === '3') {
        // Admin, Manajer, atau Superadmin
        fetch(`/notifikasi/admin/read_all/${id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.message);
            })
            .catch(error => console.log(error));
    } else {
        // Pegawai
        fetch(`/notifikasi/pegawai/read_all/${id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.message);
            })
            .catch(error => console.log(error));
    }
}


// fungsi untuk menghindari dropdown tertutup selain klik tombol dropdown itu sendiri
$(document).ready(function() {
    // ketika item dropdown di klik
    $('.dropdown-list').on('click', function(e) {
        // hindari dropdown tertutup
        e.stopPropagation();
    });

    //hindari dropdown tertutup selain klik tombol dropdown itu sendiri
    $('#menu_dropdown').on('hide.bs.dropdown', function(e) {
        if (e.clickEvent && e.clickEvent.target.className != "dropdown-toggle") {
            e.preventDefault();
        }
    });
});

// call getNotifications function when the page loads
document.addEventListener('DOMContentLoaded', getNotifications);

// call getNotifications function every 10 seconds
setInterval(getNotifications, pollingInterval);