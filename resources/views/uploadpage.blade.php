<!DOCTYPE html>
<html>
<head>
    <title>PDF Book Uploader</title>
</head>
<body>
    <h1>PDF Book Uploader</h1>
    <form method="POST" action="upload" enctype="multipart/form-data">
        @csrf
        <label for="pdf_file">Select a PDF file here:</label>
        <input type="file" name="pdf_file" id="pdf_file">
        <button type="submit">Upload</button>
    </form>

    @if (isset($checklist))
        @foreach ($checklist as $key => $value)
            @if (isset($item) && $key == 'page_count')
                @if($value == false)
                <p style="color: red;">The total number of pages in my book is an even number. (12, 14, 16, 18, 20, ...)</p>
                @elseif ($value == true)
                <p style="color: green;">The total number of pages in my book is an even number. (12, 14, 16, 18, 20, ...)</p>
                @endif
            @elseif (isset($item) && $key == 'empty_pages')
                @if($value == false)
                <p style="color: red;">The total number of pages in my book is an even number. (12, 14, 16, 18, 20, ...)</p>
                @elseif ($value == true)
                <p style="color: green;">The total number of pages in my book is an even number. (12, 14, 16, 18, 20, ...)</p>
                @endif
            @elseif (isset($item) && $key == 'size_match')
                @if($value == false)
                <p style="color: red;">The total number of pages in my book is an even number. (12, 14, 16, 18, 20, ...)</p>
                @elseif ($value == true)
                <p style="color: green;">The total number of pages in my book is an even number. (12, 14, 16, 18, 20, ...)</p>
                @endif
            @elseif (isset($item) && $key == 'safe_margin')
                @if($value == false)
                <p style="color: red;">The total number of pages in my book is an even number. (12, 14, 16, 18, 20, ...)</p>
                @elseif ($value == true)
                <p style="color: green;">The total number of pages in my book is an even number. (12, 14, 16, 18, 20, ...)</p>
                @endif
            @endif
        @endforeach
    @endif
















    @if (isset($checklist))
        @foreach ($checklist as $key => $value)
            @if (isset($item) && $key == 'page_count')
                @if($value == false)
                <p style="color: red;">The total number of pages in my book is an even number. (12, 14, 16, 18, 20, ...)</p>
                @elseif ($value == true)
                <p style="color: green;">The total number of pages in my book is an even number. (12, 14, 16, 18, 20, ...)</p>
                @endif
            @elseif (isset($item) && $key == 'empty_pages')
                @if($value == false)
                <p style="color: red;">The total number of pages in my book is an even number. (12, 14, 16, 18, 20, ...)</p>
                @elseif ($value == true)
                <p style="color: green;">The total number of pages in my book is an even number. (12, 14, 16, 18, 20, ...)</p>
                @endif
            @elseif (isset($item) && $key == 'size_match')
                @if($value == false)
                <p style="color: red;">The total number of pages in my book is an even number. (12, 14, 16, 18, 20, ...)</p>
                @elseif ($value == true)
                <p style="color: green;">The total number of pages in my book is an even number. (12, 14, 16, 18, 20, ...)</p>
                @endif
            @elseif (isset($item) && $key == 'safe_margin')
                @if($value == false)
                <p style="color: red;">The total number of pages in my book is an even number. (12, 14, 16, 18, 20, ...)</p>
                @elseif ($value == true)
                <p style="color: green;">The total number of pages in my book is an even number. (12, 14, 16, 18, 20, ...)</p>
                @endif
            @endif
        @endforeach
    @endif

</body>
</html>
