@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'health'
])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="fas fa-walking" style="color: coral;"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Steps</p>
                                    <p class="card-title">
                                        {{ $dailySteps->steps }}
                                    <p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i>
                            @if ($dailySteps->steps < 8000)
                            <span style="color: red;">
                                {{8000 - $dailySteps->steps}}
                            </span> steps behind daily goal
                            @elseif ($dailySteps->steps > 8000)

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
