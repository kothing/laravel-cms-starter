@extends('frontend.layouts.app')

@section('title') {{$$module_name_singular->name}}'s Profile @endsection

@section('content')

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-7xl mx-auto px-4 sm:px-6 py-10">
    <div class="col-span-1">
        <div class="text-center mb-8 md:mb-0">
            <div class="bg-white border shadow-lg rounded-lg px-8 py-8 text-gray-400">
                <img class="object-cover rounded-lg mx-auto" src="{{asset($$module_name_singular->avatar)}}" alt="{{$$module_name_singular->name}}" />
                <h3 class="font-title text-gray-800 text-xl mb-3">
                    {{$$module_name_singular->name}}
                </h3>
                <p>
                    {{$$module_name_singular->address}}
                </p>
                @if($userprofile->url_website)
                <a class="text-blue-800 hover:text-gray-800" target="_blank" href="{{$userprofile->url_website}}">
                    {{$userprofile->url_website}}
                </a>
                @else
                <a class="text-blue-800 hover:text-gray-800" href="{{route('frontend.users.profile', encode_id($$module_name_singular->id))}}">
                    {{route('frontend.users.profile', encode_id($$module_name_singular->id))}}
                </a>
                @endif

                @auth

                @if (auth()->user()->id == $$module_name_singular->id)
                <div class="mt-8">
                    <a href='{{ route("frontend.users.profileEdit", encode_id($$module_name_singular->id)) }}'>
                        <div class="w-full text-sm px-6 py-2 outline bg-gray-100 transition ease-in duration-200 rounded text-gray-500 hover:bg-gray-800 hover:text-white border-1 border-gray-900 focus:outline-none">
                            Edit Profile
                        </div>
                    </a>
                </div>
                @endif

                @if (auth()->user()->username == $$module_name_singular->username)
                <div class="mt-8">
                    <a href="{{ route('frontend.users.changePassword', $$module_name_singular->username) }}">
                        <div class="w-full text-sm px-6 py-2 outline bg-gray-100 transition ease-in duration-200 rounded text-gray-500 hover:bg-gray-800 hover:text-white border-1 border-gray-900 focus:outline-none">
                            Change Password
                        </div>
                    </a>
                </div>
                @endif

                @endauth

            </div>
        </div>
    </div>
    <div class="col-span-2">
        <div class="mb-8 p-6 bg-white border shadow-lg rounded-lg">
            <h3 class="text-xl font-semibold pb-4 border-b">
                Profile
            </h3>

            <div class="flex justify-between p-4">
                <div class="">
                    <span class="font-semibold">{{ label_case($field_name = 'first_name'); }}: </span>
                    <span class="">{{ $$module_name_singular->$field_name }}</span>
                </div>
                <div class="">
                    <span class="font-semibold">{{ label_case($field_name = 'last_name'); }}: </span>
                    <span class="">{{ $$module_name_singular->$field_name }}</span>
                </div>
            </div>

            @auth
            @if (auth()->user()->id == $$module_name_singular->id)
            <div class="flex justify-between p-4">
                <div class="">
                    <span class="font-semibold">{{ label_case($field_name = 'email'); }}: </span>
                    <span class="">{{ $$module_name_singular->$field_name }}</span>
                </div>
                <div class="">
                    <span class="font-semibold">{{ label_case($field_name = 'mobile'); }}: </span>
                    <span class="">{{ $$module_name_singular->$field_name }}</span>
                </div>
            </div>
            <div class="flex justify-between p-4">
                <div class="">
                    <span class="font-semibold">{{ label_case($field_name = 'date_of_birth'); }}: </span>
                    <span class="">{{ $$module_name_singular->$field_name->toFormattedDateString(); }}</span>
                </div>
                <div class="">
                    <span class="font-semibold">{{ label_case($field_name = 'gender'); }}: </span>
                    <span class="">{{ $$module_name_singular->$field_name }}</span>
                </div>
            </div>
            @endif
            @endauth

            <div class="flex flex-col justify-between p-4">
                <div class="font-semibold">
                    {{ label_case($field_name = 'bio'); }}
                </div>
                <div class="">
                    {{ $userprofile->$field_name }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push ("after-scripts")
<script type="module" src="{{ asset('vendor/sharer/sharer@0.5.1.min.js') }}"></script>
@endpush