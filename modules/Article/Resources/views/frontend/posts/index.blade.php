@extends('frontend.layouts.app')

@section('title') {{ __($module_title) }} @endsection

@section('content')

<section class="bg-gray-100 text-gray-600 py-20">
    <div class="container mx-auto flex px-5 items-center justify-center flex-col">
        <div class="text-center lg:w-2/3 w-full">
            <h1 class="text-3xl sm:text-4xl mb-4 font-medium text-gray-800">
                {{ __($module_title) }}
            </h1>
            <p class="mb-8 leading-relaxed">
                The list of {{ __($module_name) }}.
            </p>

            @include('frontend.includes.messages')
        </div>
    </div>
</section>

<section class="bg-white text-gray-600 p-6 sm:p-20">
    <div class="mx-auto flex md:flex-row flex-col">
        <div class="flex flex-col lg:flex-grow sm:w-8/12 sm:pr-8">
            <div class="grid grid-cols-1 gap-6">
                @foreach ($$module_name as $$module_name_singular)
                    @php
                        $details_url = route("frontend.$module_name.show",[encode_id($$module_name_singular->id), $$module_name_singular->slug]);
                    @endphp
                    <x-frontend.list 
                        :url="$details_url" 
                        :name="$$module_name_singular->name" 
                        :image="$$module_name_singular->featured_image"
                    >
                        @if($$module_name_singular->created_by_alias)
                        <div class="flex flex-row items-center my-4">
                            <img class="w-5 h-5 sm:w-8 sm:h-8 rounded-full" src="{{asset('images/avatars/'.rand(1, 8).'.jpg')}}" alt="Author profile image" />
                            <h6 class="text-muted text-sm small ml-2 mb-0">
                                {{ $$module_name_singular->created_by_alias }}
                            </h6>
                        </div>
                        @else
                        <div class="flex flex-row items-center my-4">
                            <img class="w-5 h-5 sm:w-8 sm:h-8 rounded-full" src="{{asset('images/avatars/'.rand(1, 8).'.jpg')}}" alt="" />
            
                            <a href='{{ route("frontend.users.profile", encode_id($$module_name_singular->created_by)) }}'>
                                <h6 class="text-muted text-sm small ml-2 mb-0">
                                    {{ $$module_name_singular->created_by_name }}
                                </h6>
                            </a>
                        </div>
                        @endif
            
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                            {{$$module_name_singular->intro}}
                        </p>
                        <div class="flex flex-row items-center">
                            <span class="w-6">
                                <i class="fa fa-fw fa-folder-open"></i>
                            </span>
                            <x-frontend.badge :url="route('frontend.categories.show', [encode_id($$module_name_singular->category_id), $$module_name_singular->category->slug])" :text="$$module_name_singular->category_name" />
                        </div>
                        @if(count($$module_name_singular->tags))
                        <div class="flex flex-row items-center">
                            <span class="w-6">
                                <i class="fa fa-tag"></i> 
                            </span>
                            @foreach ($$module_name_singular->tags as $tag)
                            <x-frontend.badge :url="route('frontend.tags.show', [encode_id($tag->id), $tag->slug])" :text="$tag->name" />
                            @endforeach
                        </div>
                        @endif
                    </x-frontend.list>
                @endforeach
            </div>
        </div>
        <div class="flex flex-col sm:w-4/12">
            <div class="py-5 sm:pt-0">
                <livewire:recent-posts />
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center w-100 mt-4">
        {{$$module_name->links()}}
    </div>
</section>
@endsection