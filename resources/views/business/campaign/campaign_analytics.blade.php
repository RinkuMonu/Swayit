@extends('business.layout.main')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Campaign Analytics</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Campaign Analytics</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
              <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                  <div class="card-header">
                    <h5>Bar Chart</h5>
                  </div>
                  <div class="card-body chart-block">
                    {{-- <canvas id="myBarGraph"></canvas> --}}
                    <canvas id="campaignBar"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                  <div class="card-header">
                    <h5>Line Graph</h5>
                  </div>
                  <div class="card-body chart-block">
                    <canvas id="myGraph"></canvas>
                  </div>
                </div>
              </div>
              {{-- <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                  <div class="card-header">
                    <h5>Radar Graph</h5>
                  </div>
                  <div class="card-body chart-block">
                    <canvas id="myRadarGraph"></canvas>
                  </div>
                </div>
              </div> --}}
              {{-- <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                  <div class="card-header">
                    <h5>Line Chart</h5>
                  </div>
                  <div class="card-body chart-block">
                    <canvas id="myLineCharts"></canvas>
                  </div>
                </div>
              </div> --}}
              {{-- <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                  <div class="card-header">
                    <h5>Doughnut Chart</h5>
                  </div>
                  <div class="card-body chart-block chart-vertical-center">
                    <canvas id="myDoughnutGraph"></canvas>
                  </div>
                </div>
              </div> --}}
              <div class="col-xl-6 col-md-12 box-col-12" style="display: none">
                <div class="card">
                  <div class="card-header">
                    <h5>Polar Chart</h5>
                  </div>
                  <div class="card-body chart-block chart-vertical-center">
                    <canvas id="myPolarGraph"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid Ends-->

    <script>
      $(document).ready(function() {
          var ctx = document.getElementById('campaignBar').getContext('2d');
          const JobChart = new Chart(ctx, {
              type: 'bar',
              data: {
                  labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "July", "Aug", "Sep", "Oct", "Nov", "Dec"],
                  datasets: [{
                      label: 'My Perfect Job',
                      backgroundColor: [
                          'rgba(255, 99, 132, 0.5)',
                          'rgba(255, 159, 64, 0.5)',
                          'rgba(255, 205, 86, 0.5)',
                          'rgba(75, 192, 192, 0.5)',
                          'rgba(54, 162, 235, 0.5)',
                          'rgba(153, 102, 255, 0.5)',
                          'rgba(201, 203, 207, 0.5)'
                      ],
                      borderColor: [
                          'rgb(255, 99, 132)',
                          'rgb(255, 159, 64)',
                          'rgb(255, 205, 86)',
                          'rgb(75, 192, 192)',
                          'rgb(54, 162, 235)',
                          'rgb(153, 102, 255)',
                          'rgb(201, 203, 207)'
                      ],
                      data: [65, 59, 80, 81, 56, 55, 40],
                  }]
              },
              options: {
                  scales: {
                      x: {
                          grid: {
                              display: false
                          }
                      },
                      y: {
                          grid: {
                              display: false
                          },
                          beginAtZero: true,
                          min: 0,
                          max: 100,
                          ticks: {
                              stepSize: 10,
                              callback: function(value) {
                                  if (value % 10 === 0) {
                                      return value;
                                  }
                              }
                          }
                      }
                  }
              },
          });
      });
      </script>
          
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <script src="{{ asset('assets/js/chart/chartjs/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/chart/chartjs/chart.custom.js') }}"></script> --}}

@endsection