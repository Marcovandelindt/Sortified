<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="{{ route('home') }}" class="simple-text logo-normal">
            {{ __('Sortified') }}
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ $elementActive == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'dashboard') }}">
                    <i class="nc-icon nc-bank"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li>
                <a href="{{ route('health.index') }}">
                    <i class="far fa-heart"></i>
                    <p>{{ __('Health') }}</p>
                </a>
            </li>
            <li>
                <a href="{{ route('food.drinks') }}">
                    <i class="fas fa-mug-hot"></i>
                    <p>{{ __('Food and Drinks') }}</p>
                </a>
            </li>
            <li>
                <a href="{{ route('music.index') }}">
                    <i class="fab fa-spotify"></i>
                    <p>{{ __('Music') }}</p>
                </a>
            </li>
            <li>
                <a href="{{ route('crypto.index') }}">
                    <i class="fab fa-bitcoin"></i>
                    <p>{{ __('Crypto\'s') }}</p>
                </a>
            </li>
            <li>
                <a href="{{ route('journals.index') }}">
                    <i class="fas fa-pencil-alt"></i>
                    <p>{{ __('Journals') }}</p>
                </a>
            </li>
            <li>
                <a href="{{ route('books.index') }}">
                    <i class="fas fa-book"></i>
                    <p>{{ __('Books') }}</p>
                </a>
            </li>
            <li>
                <a href="{{ route('games.index') }}">
                    <i class="fas fa-gamepad"></i>
                    <p>{{ __('Games') }}</p>
                </a>
            </li>
            <li>
                <a href="{{ route('calendar.index') }}">
                    <i class="fas fa-calendar-alt"></i>
                    <p>{{ __('Calendar') }}</p>
                </a>
            </li>
            <li>
                <a href="{{ route('settings.index') }}">
                    <i class="fas fa-cogs"></i>
                    <p>{{ __('Settings') }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
