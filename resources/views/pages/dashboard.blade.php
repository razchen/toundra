@extends('layouts.admin')

@section('content')
<h1>Reports status</h1>
<canvas id="myChart" width="100%" height="25%"></canvas>
@stop

@section('scripts')
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
            'November', 'December'
        ],
        datasets: [{
			label: 'Reports active',
            data: [12, 19, 3, 5, 2, 3, 8, 10, 9, 9, 12, 13],
            backgroundColor: '#8fa8c8',
            borderWidth: 1
        },{
			label: 'Reports inactive',
            data: [13, 4,4, 5, 5, 6, 4, 10, 9, 10, 15, 15],
            backgroundColor: '#e0eadf',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                },
                stacked: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Report status'
                }
            }]
        }
    }
});
</script>
@stop