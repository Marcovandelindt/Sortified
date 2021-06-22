@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'food-drinks'
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
                                    <i class="fas fa-cookie-bite" style="color: coral;"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Consumed</p>
                                    <p class="card-title">
                                        <?php
                                            if (!empty($foodLogs)) {
                                                $amount = 0;

                                                foreach ($foodLogs as $foodLog) {
                                                    $amount += $foodLog->calories;
                                                }
                                            }
                                        ?>

                                        {{ $amount }} kcal
                                    <p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-times"></i> Not at daily goal yet
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="fas fa-water" style="color: lightblue;"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Consumed</p>
                                    <p class="card-title">
                                        <?php
                                        if (!empty($waterLogs)) {
                                            $amount = 0;

                                            foreach ($waterLogs as $waterLog) {
                                                $amount += $waterLog->amount;
                                            }
                                        }
                                        ?>

                                        {{ $amount }} ml
                                    <p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-times"></i> Not at daily goal yet
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
