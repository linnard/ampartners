@extends('layouts.app')
@section('title')AM partners - Закрита партнерська база вакансій | Адмінпанель@endsection
@section('content')

    <div class="Wrapper">
        <component-header firstname="{{Auth::user()->firstname}}"
                          lastname="{{Auth::user()->lastname}}"></component-header>

        <main class="Main">
            <div class="FilterBlock">
                <div class="FilterBlock_left">
                    <form class="Search FilterBlock_search" action="">
                        <input class="FormText FormText-search Search_text" type="text" name="s" id="search"
                               placeholder="Введіть пошуковий запит">
                        <button class="Search_btn" type="submit"></button>
                    </form>
                </div>
                <div class="FilterBlock_right">

                </div>
            </div>

            <transition name="fade">
                <router-view></router-view>
            </transition>
        </main>

    </div>
@endsection
