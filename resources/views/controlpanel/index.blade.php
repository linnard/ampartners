@extends('layouts.app')
@section('title')AM partners - Закрита партнерська база вакансій | Панель керування для партнерів@endsection
@section('content')

    <div class="Wrapper">
        <component-header firstname="{{Auth::user()->firstname}}" lastname="{{Auth::user()->lastname}}"></component-header>

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
                    <div class="FilterBlock_buttons">
                        <a class="BtnBlue BtnBlue-addContact FilterBlock_quickCreationBtn" href="javascript:void(0)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="SvgIco" viewBox="0 0 16 11.79"><g data-name="Слой 2"><path class="SvgIco_path" d="M.71 1.42h7.65a.71.71 0 0 0 0-1.42H.71a.71.71 0 0 0 0 1.42zm0 3.45h7.65a.71.71 0 0 0 0-1.42H.71a.71.71 0 0 0 0 1.42zM5.08 6.9H.71a.71.71 0 0 0 0 1.42h4.37a.71.71 0 1 0 0-1.42zm10.21 0h-2.76V4.14a.71.71 0 1 0-1.42 0V6.9H8.36a.71.71 0 1 0 0 1.42h2.75v2.76a.71.71 0 0 0 1.42 0V8.32h2.76a.71.71 0 1 0 0-1.42z" fill="#fff" data-name="Capa 1"></path></g></svg>
                            Швидке створення
                        </a>
                        <label for="popupCreateNewContact" class="BtnGreen BtnGreen-addContact">
                            <svg xmlns="http://www.w3.org/2000/svg" class="SvgIco" viewBox="0 0 16 11.79"><g data-name="Слой 2"><path class="SvgIco_path" d="M.71 1.42h7.65a.71.71 0 0 0 0-1.42H.71a.71.71 0 0 0 0 1.42zm0 3.45h7.65a.71.71 0 0 0 0-1.42H.71a.71.71 0 0 0 0 1.42zM5.08 6.9H.71a.71.71 0 0 0 0 1.42h4.37a.71.71 0 1 0 0-1.42zm10.21 0h-2.76V4.14a.71.71 0 1 0-1.42 0V6.9H8.36a.71.71 0 1 0 0 1.42h2.75v2.76a.71.71 0 0 0 1.42 0V8.32h2.76a.71.71 0 1 0 0-1.42z" fill="#fff" data-name="Capa 1"></path></g></svg>
                            Створити новий контакт
                        </label>
                    </div>
                </div>
            </div>

            <transition name="fade">
                <router-view></router-view>
            </transition>
        </main>

    </div>
@endsection
