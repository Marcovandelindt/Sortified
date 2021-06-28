@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'health-statistics'
])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-6 col-md-12">
               <div class="card statistics-card">
                   <div class="card-header">
                       <h4 class="card-title">Water Intake Statistics</h4>
                       <p class="category">Take a look at your water statistics! These statistics are calculated from {{ date('d-m-Y', strtotime($firstWaterLog->date)) }} until now.</p>
                   </div>
                   <div class="card-content responsive-table table-full-width">
                       <table class="table table-striped">
                           <tbody>
                            <tr>
                                <td><i class="fas fa-ruler-horizontal ml-2"></i></td>
                                <td><span>You drank a total of {{ $waterAmount }}ml ( {{ ($waterAmount / 1000) }}l ) of water</span></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-wine-bottle ml-2"></i></td>
                                <td><span>You saved a total of {{ (floor($waterAmount / 500)) }} bottles</span></td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-money-bill-alt ml-2"></i></td>
                                <td><span>Which means a total of &euro;{{ number_format(round(floor($waterAmount / 500) * 0.35, 2), 2, '.', '') }} saved</span></td>
                            </tr>
                           </tbody>
                       </table>
                   </div>
               </div>
            </div>
        </div>
    </div>
@endsection
