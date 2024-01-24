@extends('frontend.layouts.app')

@section('title') {{$$module_name_singular->name}} @endsection

@section('content')

<section class="bg-gray-100 text-gray-600 body-font px-6 sm:px-20">
    <div class="container mx-auto flex py-8 sm:py-16 md:flex-row flex-col items-center">
        <div class="w-full flex flex-col items-center">
            <p class="mb-8 leading-relaxed">
                <a href="{{route('frontend.'.$module_name.'.index')}}" class="outline outline-1 outline-gray-800 bg-gray-200 hover:bg-gray-100 text-gray-800 text-sm font-semibold mr-2 px-3 py-1 rounded dark:bg-gray-700 dark:text-gray-300">
                    {{ __($module_title) }}
                </a>
            </p>
            <h1 class="sm:text-4xl text-3xl mb-4 font-medium text-gray-800">
                {{$$module_name_singular->name}}
            </h1>
            @if($$module_name_singular->intro != "")
            <p class="mb-8 leading-relaxed">
                {{$$module_name_singular->intro}}
            </p>
            @endif

            @include('frontend.includes.messages')
        </div>
        @if($$module_name_singular->featured_image != "")
        <div class="w-full sm:w-8/12 mb-4 sm:mb-0">
            <img class="object-cover object-center rounded shadow-md" alt="{{$$module_name_singular->name}}" src="{{$$module_name_singular->featured_image}}">
        </div>
        @endif
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
                <div class="flex flex-col sm:flex-row justify-between">
                    <div class="pb-2">
                        {{__('Written by')}}: {{isset($$module_name_singular->created_by_alias)? $$module_name_singular->created_by_alias : $$module_name_singular->created_by_name}}
                    </div>
                    <div class="pb-2">
                        {{__('Created at')}}: {{$$module_name_singular->created_at->isoFormat('llll')}}
                    </div>
                </div>
            </div>

            <div class="flex flex-row items-center py-5 border-b">
                <span class="font-weight-bold">
                        @lang('Category'):
                    </span>
                    <x-frontend.badge :url="route('frontend.categories.show', [encode_id($$module_name_singular->category_id), $$module_name_singular->category->slug])" :text="$$module_name_singular->category_name" />
            </div>

            @if (count($$module_name_singular->tags))
            <div class="py-5 border-b">
                <span class="font-weight-bold">
                    @lang('Tags'):
                </span>

                @foreach ($$module_name_singular->tags as $tag)
                <x-frontend.badge :url="route('frontend.tags.show', [encode_id($tag->id), $tag->slug])" :text="$tag->name" />
                @endforeach
            </div>
            @endif

            <div class="py-5">
                @include('article::frontend.posts.blocks.comments')
            </div>
        </div>

        <div class="flex flex-col sm:w-4/12">
            <div class="py-5 sm:pt-0">
                <livewire:recent-posts />
            </div>
        </div>
    </div>
</section>

@endsection

@push ("after-style")

@endpush

@push ("after-scripts")
<script type="module" src="{{ asset('vendor/sharer/sharer@0.5.1.min.js') }}"></script>
@endpush