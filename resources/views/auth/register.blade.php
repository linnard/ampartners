@extends('auth.layouts.app')

@section('title_page')
    AM partners - Закрита партнерська база вакансій | Реєстрація
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('label.register') }}</div>

                    <div class="card-body">


                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @else

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                {{--@if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif--}}

                                <div class="form-group required row">
                                    <label for="user[login]"
                                           class="col-md-4 col-form-label text-md-right">{{ __('field.user.login') }}
                                        :</label>

                                    <div class="col-md-6">
                                        <input id="user[login]" type="text"
                                               class="form-control @error('user.login') is-invalid @enderror"
                                               name="user[login]" value="{{ old('user.login') }}" required autofocus>

                                        @error('user.login')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group required row">
                                    <label for="password"
                                           class="col-md-4 col-form-label text-md-right">{{ __('field.user.password') }}
                                        :</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password" required>

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group required row">
                                    <label for="password_confirmation"
                                           class="col-md-4 col-form-label text-md-right">{{ __('field.user.password_confirmation') }}
                                        :</label>

                                    <div class="col-md-6">
                                        <input id="password_confirmation" type="password" class="form-control"
                                               name="password_confirmation" required>
                                    </div>
                                </div>

                                <hr>


                                <div class="form-group required row">
                                    <label for="user[firstname]"
                                           class="col-md-4 col-form-label text-md-right">{{ __('field.user.firstname') }}
                                        :</label>

                                    <div class="col-md-6">
                                        <input id="user[firstname]" type="text"
                                               class="form-control @error('user.firstname') is-invalid @enderror"
                                               name="user[firstname]" value="{{ old('user.firstname') }}" required>

                                        @error('user.firstname')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group required row">
                                    <label for="user[lastname]"
                                           class="col-md-4 col-form-label text-md-right">{{ __('field.user.lastname') }}
                                        :</label>

                                    <div class="col-md-6">
                                        <input id="user[lastname]" type="text"
                                               class="form-control @error('user.lastname') is-invalid @enderror"
                                               name="user[lastname]" value="{{ old('user.lastname') }}" required>

                                        @error('user.lastname')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group required row">
                                    <label for="user[patronymic]"
                                           class="col-md-4 col-form-label text-md-right">{{ __('field.user.patronymic') }}
                                        :</label>

                                    <div class="col-md-6">
                                        <input id="user[patronymic]" type="text"
                                               class="form-control @error('user.patronymic') is-invalid @enderror"
                                               name="user[patronymic]" value="{{ old('user.patronymic') }}" required>

                                        @error('user.patronymic')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Company fields -->
                                <hr>

                                <div class="form-group row">
                                    <label for="company[name]"
                                           class="col-md-4 col-form-label text-md-right">{{ __('field.company.name') }}
                                        :</label>

                                    <div class="col-md-6">
                                        <input id="company[name]" type="text"
                                               class="form-control @error('company.name') is-invalid @enderror"
                                               name="company[name]" value="{{ old('company.name') }}">

                                        @error('company.name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="company[phone]"
                                           class="col-md-4 col-form-label text-md-right">{{ __('field.company.phone') }}
                                        :</label>

                                    <div class="col-md-6">
                                        <input id="company[phone]" type="text"
                                               class="form-control @error('company.phone') is-invalid @enderror"
                                               name="company[phone]" value="{{ old('company.phone') }}">

                                        @error('company.phone')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="company[viber]"
                                           class="col-md-4 col-form-label text-md-right">{{ __('field.company.viber') }}
                                        :</label>

                                    <div class="col-md-6">
                                        <input id="company[viber]" type="text"
                                               class="form-control @error('company.viber') is-invalid @enderror"
                                               name="company[viber]" value="{{ old('company.viber') }}">
                                        @error('company.viber')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="company[site]"
                                           class="col-md-4 col-form-label text-md-right">{{ __('field.company.site') }}
                                        :</label>

                                    <div class="col-md-6">
                                        <input id="company[site]" type="text"
                                               class="form-control @error('company.site') is-invalid @enderror"
                                               name="company[site]" value="{{ old('company.site') }}">

                                        @error('company.site')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>


                                {{--<div class="form-group row">
                                    <label for="company[license_url]"
                                           class="col-md-4 col-form-label text-md-right">{{ __('field.company.license_url') }}
                                        :</label>

                                    <div class="col-md-6">
                                        <input id="company[license_url]" type="text"
                                               class="form-control @error('company.license_url') is-invalid @enderror"
                                               name="company[license_url]" value="{{ old('company.license_url') }}">

                                        @error('company.license_url')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>--}}

                                <div class="form-group row">
                                    <label for="company[facebook_url]"
                                           class="col-md-4 col-form-label text-md-right">{{ __('field.company.facebook_url') }}
                                        :</label>

                                    <div class="col-md-6">
                                        <input id="company[facebook_url]" type="text"
                                               class="form-control @error('company.facebook_url') is-invalid @enderror"
                                               name="company[facebook_url]" value="{{ old('company.facebook_url') }}">

                                        @error('company.facebook_url')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                {{--<div class="form-group row">
                                    <label for="company[instagram_url]"
                                           class="col-md-4 col-form-label text-md-right">{{ __('field.company.instagram_url') }}
                                        :</label>

                                    <div class="col-md-6">
                                        <input id="company[instagram_url]" type="text"
                                               class="form-control @error('company.instagram_url') is-invalid @enderror"
                                               name="company[instagram_url]" value="{{ old('company.instagram_url') }}">

                                        @error('company.instagram_url')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>--}}

                                {{--<div class="form-group row">
                                    <label for="company[other_url]"
                                           class="col-md-4 col-form-label text-md-right">{{ __('field.company.other_url') }}
                                        :</label>

                                    <div class="col-md-6">
                                        <input id="company[other_url]" type="text"
                                               class="form-control @error('company.other_url') is-invalid @enderror"
                                               name="company[other_url]" value="{{ old('company.other_url') }}">

                                        @error('company.other_url')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>--}}

                                <div class="form-group row">
                                    <label for="company[additional_info]"
                                           class="col-md-4 col-form-label text-md-right">{{ __('field.company.additional_info') }}
                                        :</label>

                                    <div class="col-md-6">
                                        <textarea rows="4" id="company[additional_info]" class="form-control"
                                                  name="company[additional_info]">{{ old('company.additional_info') }}</textarea>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="company[email]"
                                           class="col-md-4 col-form-label text-md-right">{{ __('field.company.email') }}
                                        :</label>

                                    <div class="col-md-6">
                                        <input id="company[email]" type="email"
                                               class="form-control @error('company.email') is-invalid @enderror"
                                               name="company[email]" value="{{ old('company.email') }}">
                                        @error('company.email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <hr>

                                <div class="form-group required row">
                                    <div class="col-md-4 text-md-right">
                                        <input type="checkbox" id="agreement"
                                               class="form-check-input @error('agreement') is-invalid @enderror"
                                               name="agreement" value="{{ old('agreement') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="agreement" class="form-check-label">{{ __('field.agreement') }}</label>
                                    </div>

                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('button.register') }}
                                        </button>
                                    </div>
                                </div>
                            </form>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
