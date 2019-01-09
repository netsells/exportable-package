<!doctype html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!-- Bootstrap 3 css for table -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>

<body>
    <div>
        <div class="content">
            @if(count($exportData) > 0)
            <table class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        @foreach($headers as $key => $header)
                            <th>{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($exportData as $row)
                        <tr>
                            @foreach($headers as $key => $header)
                                @if(array_key_exists($key, $row))
                                    <td>{{ $row[$key] }}</td>
                                @else
                                    <td>&nbsp;</td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</body>
