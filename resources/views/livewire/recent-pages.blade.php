<div class="container flex flex-col mx-auto w-full items-center justify-center">
    <div class="px-4 py-3 sm:px-6 w-full border-gray-400 bg-white shadow mb-4 rounded-md">
        <h3 class="text-lg leading-6 font-medium text-gray-800">
            @lang('Recent Pages')
        </h3>
        <p class="max-w-2xl text-sm text-gray-500 mb-0">
            Recently published pages!
        </p>
    </div>
    <ul class="w-full border-gray-400 rounded-md shadow hover:shadow-lg py-3">
        @foreach ($recentPages as $row)
        @php
        $details_url = route("frontend.pages.show",[encode_id($row->id), $row->slug]);
        @endphp
        <li class="flex items-center flex-row flex-1 transition duration-500 ease-in-out transform hover:-translate-y-1 px-4 py-2">
            @if($row->featured_image != "")     
            <div class="flex flex-col h-10 justify-center items-center mr-4">
                <a href="{{$details_url}}" class="block relative">
                    <img alt="{{ $row->name }}" src="{{$row->featured_image}}" class="mx-auto object-cover rounded h-10 " />
                </a>
            </div>
            @endif
            <div class="flex-1 pl-1">
                <div class="font-medium">
                    <a href="{{$details_url}}">
                        {{ $row->name }}
                    </a>
                </div>
                <div class="text-gray-600 text-sm">
                    {{$row->created_at}}
                </div>
            </div>
            <button class="w-10 text-right flex justify-end">
                <svg width="12" fill="currentColor" height="12" class="hover:text-gray-800 text-gray-500" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1363 877l-742 742q-19 19-45 19t-45-19l-166-166q-19-19-19-45t19-45l531-531-531-531q-19-19-19-45t19-45l166-166q19-19 45-19t45 19l742 742q19 19 19 45t-19 45z">
                    </path>
                </svg>
            </button>
        </li>
        @endforeach
    </ul>
</div>
