@extends("user.layouts.master")
@section("content")
    <div>
        <canvas id="myChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('myChart');
        const products = {!! json_encode($products) !!};
        function getRandomNumber(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        // Sử dụng hàm getRandomColor để lấy một mã màu ngẫu nhiên
        let datasets = [];
        Object.entries(products).forEach(function([key, arrayContents]) {
            datasets.push({
                label: key,
                data: arrayContents,
                fill: false,
                borderColor: getRandomColor(),
                tension: 0.1
            });
        });
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December"
                ],
                datasets: datasets
            },
        });
    </script>
@endsection
