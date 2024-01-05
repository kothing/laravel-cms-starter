@extends('frontend.layouts.app')

@section('title') {{$$module_name_singular->name}} - {{ __($module_title) }} @endsection

@section('content')

<section class="bg-gray-100 text-gray-600 py-10 sm:py-20">
    <div class="container mx-auto flex px-5 items-center justify-center flex-col">
        <div class="w-full flex flex-col items-center">
            <p class="mb-8 leading-relaxed">
                <a href="{{route('frontend.'.$module_name.'.index')}}" class="outline outline-1 outline-gray-800 bg-gray-200 hover:bg-gray-100 text-gray-800 text-sm font-semibold mr-2 px-3 py-1 rounded dark:bg-gray-700 dark:text-gray-300">
                    {{ __($module_title) }}
                </a>
            </p>
            <h1 class="text-3xl sm:text-4xl mb-4 font-medium text-gray-800">
                {{$$module_name_singular->name}}
            </h1>
            <p class="mb-8 leading-relaxed">
                {{$$module_name_singular->description}}
            </p>

            @include('frontend.includes.messages')
        </div>
    </div>
</section>

<section class="py-6 sm:py-10 px-6 sm:px-20">
    <div class="container mx-auto flex md:flex-row flex-col">
        <div class="flex flex-col lg:flex-grow sm:w-8/12 sm:pr-8">
            <div class="pb-5">
                <p>
                    {!!$$module_name_singular->content!!}
                </p>
            </div>

            <hr>

            <div class="py-5 border-b">
                <div class="flex flex-col">
                    <div class="pb-2">
                        {{__('Created at')}}: {{$$module_name_singular->created_at->isoFormat('llll')}}
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:w-4/12">
            <div class="py-5 sm:pt-0">
                <livewire:recent-pages />
            </div>
        </div>
    </div>
</section>

@endsection