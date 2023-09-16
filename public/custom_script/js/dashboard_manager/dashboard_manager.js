// dashboard.js
document.addEventListener('DOMContentLoaded', function() {
    fetch('/manager/dashboard/data')
        .then(response => response.json())
        .then(data => {
            // Menyiapkan data untuk grafik total permintaan harian, mingguan, dan bulanan
            const dailyData = processData(data, 'daily');
            const weeklyData = processData(data, 'weekly');
            const monthlyData = processData(data, 'monthly');

            // Membuat grafik total permintaan harian, mingguan, dan bulanan
            createRequestsChart(dailyData, 'dailyRequestsChart', 'Total Permintaan Harian', 'Tanggal');
            createRequestsChart(weeklyData, 'weeklyRequestsChart', 'Total Permintaan Mingguan',
                'Minggu');
            createRequestsChart(monthlyData, 'monthlyRequestsChart', 'Total Permintaan Bulanan',
                'Bulan');

            // Membuat grafik tipe permintaan
            createTypeChart(data);

            // Membuat grafik status permintaan
            createStatusChart(data);
        })
        .catch(error => {
            console.error('Terjadi kesalahan:', error);
        });

    // Fungsi untuk memproses data permintaan menjadi data untuk grafik total permintaan harian, mingguan, dan bulanan
    function processData(data, interval) {
        // Mengurutkan data berdasarkan tanggal permintaan
        data.sort((a, b) => new Date(a.tanggal_permintaan) - new Date(b.tanggal_permintaan));

        // Mengelompokkan data berdasarkan tanggal atau minggu atau bulan
        const groupedData = data.reduce((result, entry) => {
            const date = new Date(entry.tanggal_permintaan);
            const formattedDate = formatDate(date, interval);

            if (!result[formattedDate]) {
                result[formattedDate] = 0;
            }

            result[formattedDate]++;
            return result;
        }, {});

        // Menghasilkan array data dengan format yang dibutuhkan oleh Chart.js
        const labels = Object.keys(groupedData);
        const values = Object.values(groupedData);
        return {
            labels: labels,
            values: values
        };
    }

    // Fungsi untuk memformat tanggal berdasarkan interval (daily, weekly, monthly)
    function formatDate(date, interval) {
        switch (interval) {
            case 'daily':
                return date.toLocaleDateString();
            case 'weekly':
                return 'W' + getWeekNumber(date) + ' ' + date.getFullYear();
            case 'monthly':
                return date.toLocaleString('default', {
                    month: 'long',
                    year: 'numeric'
                });
            default:
                return '';
        }
    }


    // Fungsi untuk mendapatkan nomor minggu dari tanggal
    function getWeekNumber(date) {
        const onejan = new Date(date.getFullYear(), 0, 1);
        return Math.ceil(((date - onejan) / 86400000 + onejan.getDay() + 1) / 7);
    }

    // Fungsi untuk membuat grafik dengan Chart.js
    function createRequestsChart(data, chartId, chartLabel, xAxisLabel) {
        const ctx = document.getElementById(chartId).getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: chartLabel,
                    data: data.values,
                    fill: true,
                    backgroundColor: 'cyan',
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.2
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: xAxisLabel
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Permintaan'
                        },

                    }
                }
            }
        });
    }

    // Fungsi untuk membuat grafik tipe permintaan
    function createTypeChart(data) {
        const typeData = {
            labels: ['Hardware', 'Software'],
            datasets: [{
                data: [
                    data.filter(entry => entry.tipe_permintaan == 'hardware').length,
                    data.filter(entry => entry.tipe_permintaan == 'software').length
                ],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)'
                ]
            }]
        };

        const ctx = document.getElementById('typeChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: typeData,
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'right'
                    }
                }
            }
        });
    }

    // Fungsi untuk membuat grafik status permintaan
    // 1 = Pending, 2 = Menunggu Persetujuan, 3 = Diterima, 4 = Diproses,
    // 5 = Instalasi selesai, 6 = Proses Selesai, 0 = Ditolak
    function createStatusChart(data) {
        const statusLabels = ['Pending', 'Menunggu Otorisasi', 'Diterima', 'Diproses Admin', 'Instalasi Selesai', 'Permintaan Selesai', 'Ditolak'];
        const statusAll = ['1', '2', '3', '4', '5', '6', '0'];
        const statusData = {
            labels: statusLabels,
            datasets: [{
                data: statusAll.map(status => data.filter(entry => entry
                    .status_permintaan === status).length),
                backgroundColor: [
                    'red', // 1
                    'blue', // 2
                    'green', // 3
                    'orange', // 4
                    'lightgreen', // 5
                    'lime', // 6
                    'gray', // 0

                ]
            }]
        };

        const ctx = document.getElementById('statusChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: statusData,
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'right'
                    }
                }
            }
        });
    }
});