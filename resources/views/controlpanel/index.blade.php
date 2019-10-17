@extends('layouts.app')
@section('title')AM partners - Закрита партнерська база вакансій | Панель керування для партнерів@endsection
@section('content')

    <div class="Wrapper">
        <component-header></component-header>

        <main class="Main">
            <transition name="fade">
                <router-view></router-view>
            </transition>
        </main>

    </div>
@endsection
