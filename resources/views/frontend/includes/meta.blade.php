@if (isset($$module_name_singular))
    @php
    if(!isset($meta_page_type)){
        $meta_page_type = 'website';
    }
    @endphp

    @switch($meta_page_type)
        @case('website')
            <meta property="page:type" content="website" />
            @break

        @case('page')
            <meta property="page:type" content="page" />
            <meta property="page:meta_title" content="{{$$module_name_singular->meta_title}}" />
            <meta property="page:meta_keywords" content="{{$$module_name_singular->meta_keywords}}" />
            <meta property="page:meta_description" content="{{$$module_name_singular->meta_description}}" />
            <meta property="page:published_time" content="{{$$module_name_singular->created_at}}" />
            <meta property="page:modified_time" content="{{$$module_name_singular->updated_at}}" />
            <meta property="page:author" content="{{isset($$module_name_singular->created_by_alias)? $$module_name_singular->created_by_alias : $$module_name_singular->created_by_name}}" />

            @break

        @case('article')
            <meta property="page:type" content="article" />
            <meta property="article:meta_title" content="{{$$module_name_singular->meta_title}}" />
            <meta property="article:meta_keywords" content="{{$$module_name_singular->meta_keywords}}" />
            <meta property="article:meta_description" content="{{$$module_name_singular->meta_description}}" />
            @php
            $tags_arr = array();;
            foreach($$module_name_singular->tags as $tag) {
                array_push($tags_arr, $tag->name);
            }
            @endphp
            <meta property="article:tag" content="{{implode(',', $tags_arr)}}" />
            <meta property="article:published_time" content="{{$$module_name_singular->created_at}}" />
            <meta property="article:modified_time" content="{{$$module_name_singular->updated_at}}" />
            <meta property="article:author" content="{{isset($$module_name_singular->created_by_alias)? $$module_name_singular->created_by_alias : $$module_name_singular->created_by_name}}" />
            <meta property="article:category_name" content="{{$$module_name_singular->category_name}}" />

            @break

            @break

        @case('profile')
            <meta property="page:type" content="profile" />
            <meta property="profile:first_name" content="{{$$module_name_singular->first_name}}" />
            <meta property="profile:last_name" content="{{$$module_name_singular->last_name}}" />
            <meta property="profile:username" content="{{$$module_name_singular->email}}" />
            <meta property="profile:gender" content="{{$$module_name_singular->gender}}" />
            @break

        @default

    @endswitch

modules/Tag/Resources/lang/en/list.php

<!-- Meta -->
<!--
<meta property="og:url" content="{{url()->full()}}" />
<meta property="og:title" content="@yield('title') | {{ config('app.name') }}" />
<meta property="og:site_name" content="{{setting('meta_site_name')}}" />
<meta property="og:description" content="{{ setting('meta_description') }}" />
<meta property="og:image" content="{{ asset(setting('meta_image')) }}" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
-->

<!-- Twitter Meta -->
<!-- 
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="{{ setting('meta_twitter_site') }}">
<meta name="twitter:url" content="{{url()->full()}}" />
<meta name="twitter:creator" content="{{ setting('meta_twitter_creator') }}">
<meta name="twitter:title" content="@yield('title') | {{ config('app.name') }}">
<meta name="twitter:description" content="{{ setting('meta_description') }}">
<meta name="twitter:image" content="{{ asset(setting('meta_image')) }}">
-->

<!--canonical link-->
<meta name="generator" content="Laravel CMS Starter - A modular CMS starter application built with Laravel 10.x." />
<link rel="canonical" href="{{url()->full()}}">
