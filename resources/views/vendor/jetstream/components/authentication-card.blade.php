<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 px-3 md:px-2 sm:pt-0 bg-gray-100">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4  bg-gray-800 text-yellow-400 shadow-md overflow-hidden sm:rounded-lg rounded">
        {{ $slot }}
    </div>
</div>
