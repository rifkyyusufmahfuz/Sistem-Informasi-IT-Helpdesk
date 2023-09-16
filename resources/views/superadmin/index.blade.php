@extends('layouts.main')

@section('contents')
    {{-- container --}}
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h6 class="text-center">Jumlah Barang Berdasarkan Status</h6>
                <canvas id="barang-chart" width="200" height="150"></canvas>
            </div>
            <div class="col-md-4">
                <h6 class="text-center">Jumlah BAST Berdasarkan Jenis BAST</h6>
                <canvas id="bast-chart" width="200" height="150"></canvas>
            </div>
            <div class="col-md-4">
                <h6 class="text-center">Jumlah Permintaan Berdasarkan Tipe Permintaan</h6>
                <canvas id="permintaan-chart-tipe" width="200" height="150"></canvas>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <h6 class="text-center">Jumlah Permintaan Berdasarkan Status</h6>
                <canvas id="permintaan-chart" width="200" height="60"></canvas>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <h6 class="text-center">Jumlah Users</h6>
                <canvas id="users-chart" width="200" height="150"></canvas>
            </div>
            <div class="col-md-4">
                <h6 class="text-center">Jumlah Pegawai Berdasarkan Role</h6>
                <canvas id="pegawai-role-chart" width="200" height="150"></canvas>
            </div>
            <div class="col-md-4">
                <h6 class="text-center">Jumlah Pegawai dengan Akun User</h6>
                <canvas id="pegawai-chart" width="200" height="150"></canvas>
            </div>
        </div>


        <hr>

        <div class="mt-2">
            <h4 class="text-center">Jumlah Pegawai Per Stasiun</h4>
            <div class="row justify-content-center">
                <div class="col-2 text-center">
                    <label for="start-range-input">Rentang Awal:</label>
                    <select id="start-range-input" class="form-control text-center">
                        <!-- Opsi rentang awal -->
                    </select>
                </div>
                <div class="col-2 text-center d-flex justify-content-center align-items-center">
                    <span>-</span>
                </div>
                <div class="col-2 text-center">
                    <label for="end-range-input">Rentang Akhir:</label>
                    <select id="end-range-input" class="form-control text-center">
                        <!-- Opsi rentang akhir -->
                    </select>
                </div>
            </div>

            <div class="">
                <div class="" id="stasiun-count-info"></div>
                <div class="" id="pegawai-count-info"></div>
            </div>

            <canvas id="stasiun-chart"></canvas>
        </div>



        {{-- Untuk BAST --}}
        <script>
            var bastCountsByType = {!! $bastCountsByType !!};

            var jenisLabels = [];
            var jumlahBAST = [];

            for (var i = 0; i < bastCountsByType.length; i++) {
                jenisLabels.push(bastCountsByType[i].jenis_bast);
                jumlahBAST.push(bastCountsByType[i].jumlah_bast);
            }

            var bastChartCanvas = document.getElementById('bast-chart').getContext('2d');
            var bastChart = new Chart(bastChartCanvas, {
                type: 'pie',
                data: {
                    labels: jenisLabels,
                    datasets: [{
                        data: jumlahBAST,
                        backgroundColor: ['blue',
                            'red'
                        ] // Sesuaikan warna sesuai dengan jumlah jenis_bast yang ada
                    }]
                },
                options: {
                    responsive: true,
                    // Opsi konfigurasi lainnya
                }
            });
        </script>



        {{-- Untuk permintaan --}}
        <script>
            var permintaanCountsByType = {!! $permintaanCountsByType !!};

            var tipeLabels = [];
            var jumlahPermintaanByType = [];

            for (var i = 0; i < permintaanCountsByType.length; i++) {
                tipeLabels.push(permintaanCountsByType[i].tipe_permintaan);
                jumlahPermintaanByType.push(permintaanCountsByType[i].jumlah_permintaan);
            }

            var permintaanChartCanvas = document.getElementById('permintaan-chart-tipe').getContext('2d');
            var permintaanChart = new Chart(permintaanChartCanvas, {
                type: 'pie',
                data: {
                    labels: tipeLabels,
                    datasets: [{
                        data: jumlahPermintaanByType,
                        backgroundColor: ['green',
                            'blue'
                        ] // Sesuaikan warna sesuai dengan jumlah tipe_permintaan yang ada
                    }]
                },
                options: {
                    responsive: true,
                    // Opsi konfigurasi lainnya
                }
            });
        </script>


        {{-- Script untuk grafik permintaan berdasarkan status --}}
        <script>
            var sortedChartData = {!! json_encode($sortedChartData) !!};

            var statusPermintaanLabels = ['Pending', 'Ditinjau', 'Menunggu Unit', 'Diproses', 'Unit Siap Diambil',
                'Permintaan Selesai', 'Ditolak'
            ];

            var statusPermintaanColors = ['#e74a3b', '#f6c23e', '#36b9cc', '#4e73df', '#858796', '#1cc88a',
                '#5a5c69'
            ];

            var jumlahPermintaanHardware = [];

            // Pemetaan data dari sortedChartData ke dalam jumlahPermintaanHardware
            statusPermintaanLabels.forEach(function(label) {
                jumlahPermintaanHardware.push(sortedChartData[label] || 0);
            });

            var statusPermintaanChartCanvas = document.getElementById('permintaan-chart').getContext('2d');
            var statusPermintaanChart = new Chart(statusPermintaanChartCanvas, {
                type: 'pie',
                data: {
                    labels: statusPermintaanLabels,
                    datasets: [{
                        data: jumlahPermintaanHardware,
                        backgroundColor: statusPermintaanColors
                    }]
                },
                options: {
                    responsive: true,
                    // Opsi konfigurasi lainnya
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {
                        display: true
                    },
                }
            });
        </script>


        {{-- untuk barang --}}
        <script>
            var barangCounts = {!! $barangCounts !!};

            var statusLabels = [];
            var jumlahBarang = [];

            for (var i = 0; i < barangCounts.length; i++) {
                statusLabels.push(barangCounts[i].status_barang);
                jumlahBarang.push(barangCounts[i].jumlah_barang);
            }

            var barangChartCanvas = document.getElementById('barang-chart').getContext('2d');
            var barangChart = new Chart(barangChartCanvas, {
                type: 'pie',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: jumlahBarang,
                        backgroundColor: ['green', 'blue', 'orange',
                            'red'
                        ] // Sesuaikan warna sesuai dengan jumlah status_barang yang ada
                    }]
                },
                options: {
                    responsive: true,
                    // Opsi konfigurasi lainnya
                }
            });
        </script>


        {{-- untuk menampilkan chart total pegawai terdaftar dan tidak terdaftar --}}
        <script>
            var pegawaiChartCanvas = document.getElementById('pegawai-chart').getContext('2d');
            var pegawaiChart;

            // Mendapatkan jumlah pegawai yang terdaftar di sistem
            var pegawaiTerdaftar = {!! $pegawaiTerdaftar !!};

            // Mendapatkan jumlah total pegawai
            var totalPegawai = {!! $totalPegawai !!};

            // Menghitung jumlah pegawai yang belum terdaftar di sistem
            var pegawaiBelumTerdaftar = totalPegawai - pegawaiTerdaftar;

            function updatePegawaiChart() {
                if (pegawaiChart) {
                    pegawaiChart.destroy();
                }

                pegawaiChart = new Chart(pegawaiChartCanvas, {
                    type: 'pie',
                    data: {
                        labels: ['Terdaftar', 'Belum Terdaftar'],
                        datasets: [{
                            data: [pegawaiTerdaftar, pegawaiBelumTerdaftar],
                            backgroundColor: ['green', 'red']
                        }]
                    },
                    options: {
                        // Opsi konfigurasi lainnya
                    }
                });
            }

            // Memperbarui grafik
            updatePegawaiChart();
        </script>

        {{-- untuk user aktif atau tidak aktif dan berdasarkan role --}}
        <script>
            var activeUsersCount = {{ $activeUsersCount }};
            var inactiveUsersCount = {{ $inactiveUsersCount }};

            var usersChartCanvas = document.getElementById('users-chart').getContext('2d');
            new Chart(usersChartCanvas, {
                type: 'pie',
                data: {
                    labels: ['Aktif', 'Tidak Aktif'],
                    datasets: [{
                        data: [activeUsersCount, inactiveUsersCount],
                        backgroundColor: ['blue', 'red']
                    }]
                },
                options: {
                    // Opsi konfigurasi lainnya
                }
            });

            var pegawaiByRole = {!! $pegawaiByRole !!};

            var pegawaiRoleLabels = [];
            var pegawaiRoleCounts = [];

            for (var i = 0; i < pegawaiByRole.length; i++) {
                pegawaiRoleLabels.push(pegawaiByRole[i].nama_role);
                pegawaiRoleCounts.push(pegawaiByRole[i].pegawai_count);
            }

            var pegawaiRoleChartCanvas = document.getElementById('pegawai-role-chart').getContext('2d');
            new Chart(pegawaiRoleChartCanvas, {
                type: 'pie',
                data: {
                    labels: pegawaiRoleLabels,
                    datasets: [{
                        data: pegawaiRoleCounts,
                        backgroundColor: ['blue', 'yellow', 'green', 'orange']
                    }]
                },
                options: {
                    // Opsi konfigurasi lainnya
                }
            });
        </script>


        {{-- untuk pegawai berdasarkan stasiun --}}
        <script>
            var startRangeInput = document.getElementById('start-range-input');
            var endRangeInput = document.getElementById('end-range-input');

            var stasiunCounts = {!! $stasiunCount !!};
            var stasiunLetters = [];

            for (var i = 0; i < stasiunCounts.length; i++) {
                var letter = stasiunCounts[i].nama_stasiun.charAt(0);

                if (!stasiunLetters.includes(letter)) {
                    stasiunLetters.push(letter);

                    var startOption = document.createElement('option');
                    startOption.value = letter;
                    startOption.text = letter;
                    startRangeInput.appendChild(startOption);

                    var endOption = document.createElement('option');
                    endOption.value = letter;
                    endOption.text = letter;
                    endRangeInput.appendChild(endOption);
                }
            }

            startRangeInput.addEventListener('change', function() {
                var selectedStartRange = startRangeInput.value;
                updateEndRangeOptions(selectedStartRange);
            });

            function updateEndRangeOptions(selectedStartRange) {
                // Menghapus semua opsi select box rentang akhir
                endRangeInput.innerHTML = '';

                // Mengisi ulang select box rentang akhir dengan huruf yang memiliki data stasiun setelah atau sama dengan rentang awal yang dipilih
                var startRangeIndex = stasiunLetters.findIndex(letter => letter === selectedStartRange);
                for (var i = startRangeIndex; i < stasiunLetters.length; i++) {
                    var letter = stasiunLetters[i];
                    var option = document.createElement('option');
                    option.value = letter;
                    option.text = letter;
                    endRangeInput.appendChild(option);
                }
            }
        </script>

        <script>
            var stasiunCounts = {!! $stasiunCount !!};

            var stasiunLabels = [];
            var stasiunData = [];

            for (var i = 0; i < stasiunCounts.length; i++) {
                stasiunLabels.push(stasiunCounts[i].nama_stasiun);
                stasiunData.push(stasiunCounts[i].pegawai_count);
            }

            var stasiunChartCanvas = document.getElementById('stasiun-chart').getContext('2d');
            var stasiunChart;

            function updateStasiunChart(startRange, endRange) {
                if (stasiunChart) {
                    stasiunChart.destroy();
                }

                var start = stasiunLabels.findIndex(label => label.charAt(0) === startRange);
                var end = stasiunLabels.findIndex(label => label.charAt(0) === endRange);

                var labels = [];
                var data = [];

                if (start < 0) {
                    start = 0;
                }

                if (end < 0) {
                    end = stasiunLabels.length - 1;
                }

                labels = stasiunLabels.slice(start, end + 1);
                data = stasiunData.slice(start, end + 1);

                stasiunChart = new Chart(stasiunChartCanvas, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Pegawai',
                            data: data,
                            backgroundColor: 'blue'
                        }]
                    },
                    options: {
                        // Opsi konfigurasi lainnya
                    }
                });

                var stasiunCount = data.reduce((total, count) => total + count, 0);
                document.getElementById('pegawai-count-info').innerHTML = 'Jumlah Pegawai: ' + stasiunCount;

                var total_stasiun = stasiunLabels.length;
                document.getElementById('stasiun-count-info').innerHTML = 'Total Stasiun: ' + total_stasiun;


            }


            // Mengupdate grafik saat nilai input diubah
            startRangeInput.addEventListener('change', function() {
                var startRangeValue = startRangeInput.value;
                var endRangeValue = endRangeInput.value;
                updateStasiunChart(startRangeValue, endRangeValue);
            });

            endRangeInput.addEventListener('change', function() {
                var startRangeValue = startRangeInput.value;
                var endRangeValue = endRangeInput.value;
                updateStasiunChart(startRangeValue, endRangeValue);
            });

            // Memperbarui grafik dengan nilai awal
            var defaultStartRangeValue = stasiunLabels[0].charAt(0);
            var defaultEndRangeValue = stasiunLabels[stasiunLabels.length - 1].charAt(0);
            startRangeInput.value = defaultStartRangeValue;
            endRangeInput.value = defaultEndRangeValue;
            updateStasiunChart(defaultStartRangeValue, defaultEndRangeValue);
        </script>

    </div>
@endsection
