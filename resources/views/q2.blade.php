<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite('resources/css/app.css')
</head>

<body class="antialiased">
    <div id="app">
        <div
            class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white min-w-screen">
            <div class="max-w-7xl mx-auto p-6 lg:p-8 w-full">
                <form name="add-blog-post-form" id="add-blog-post-form" method="get" action="{{ url('q2') }}"
                    class="max-w-lg mx-auto space-y-5">
                    @csrf
                    <div class="flex flex-col space-y-3">
                        <label for="exampleInputEmail1">Total Note</label>
                        <input name="total_note"
                            class="h-12 rounded-lg shadow border appearance-none border-rounded w-full px-3 text-gray-700 leading-tight focus:outline-dashed focus:shadow-outline "
                            type="number" value="{{ old('total_note') }}">
                        @if ($errors->any())
                            <div class="w-full text-red-500 text-center">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <button type="submit"
                        class="bg-violet-500 font-semibold text-white w-full rounded-lg py-3 hover:opacity-90">Submit</button>
                </form>
                <div class="mb-6 flex flex-col">
                    @php
                        $array = [3 => 'Fintegra', 5 => 'Homido Indonesia', 15 => 'Fintegra Homindo Indonesia'];
                    @endphp
                    <div class="flex m-8 w-full flex-col items-center justify-center space-y-8">
                        @if ($special_note)
                            @for ($i = 1; $i <= request('total_note'); $i++)
                                <div class="flex flex-row w-full items-center justify-center">
                                    <div class="h-20 w-20 rounded-full shadow-md">
                                        <label
                                            class="flex items-center justify-center font-semibold text-2xl h-20 w-20 text-center">
                                            @php
                                                echo $i;
                                            @endphp
                                        </label>
                                    </div>
                                    <div class="h-20 w-full flex items-end justify-end">

                                        @php
                                            $palaceholder = '';
                                            if (in_array($i, array_keys($special_note))) {
                                                $palaceholder = $special_note[$i];
                                            }
                                        @endphp

                                        <input
                                            class="h-12 rounded-lg shadow border appearance-none border-rounded w-full px-3 text-gray-700 leading-tight focus:outline-dashed focus:shadow-outline "
                                            type="text"
                                            placeholder="{{ $palaceholder }}">
                                    </div>
                                </div>
                            @endfor
                        @endif
                    </div>
                </div>
            </div>
        </div>
</body>

</html>
