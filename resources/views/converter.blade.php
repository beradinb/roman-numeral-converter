<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ env('APP_NAME') }}</title>

        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

        <style>
            .overlined {
              text-decoration: overline; /* Specify the overline style */
            }
          </style>
    </head>
    <body class="bg-gray-100 min-h-screen flex items-center justify-center">


        <div class="max-w-md w-full bg-white p-8 rounded shadow-lg">
            <h1 class="text-2xl font-bold mb-4">Roman Numeral Converter</h1>
            <form action="/convert" method="POST" class="mb-4">
                @csrf
                <label for="input" class="block mb-2">Enter an Integer or Roman Numeral:</label>
                <input type="text" id="input" name="input" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Convert</button>
            </form>
            <div id="output" class="text-xl font-bold"></div>
        </div>
    

        <script>
            document.querySelector('form').addEventListener('submit', async function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                const response = await fetch('/convert', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();
                if (!response.ok) {
                    // console.error(data.error);
                    document.getElementById('output').innerText = data.error;
                    return;
                }
                console.log(data);
                var element = document.getElementById('output');
                element.innerText = data.output; // Set the text content of the element

                // Create a span element with the overlined class for the specified number of characters
                var overlinedText = '<span class="overlined">' + data.output.substr(0, data.underscoreCount) + '</span>' + data.output.substr(data.underscoreCount);
                element.innerHTML = overlinedText; 
            });
        </script>
    </body>
</html>
