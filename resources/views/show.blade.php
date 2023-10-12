<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</head>

<body class="p-5">
    <a class=" btn btn-primary m-4" href="/">Create product</a>
    @if (session(' img_!found_err'))
        <p class=" text-danger">{{ session(' img_!found_err') }}</p>
    @endif
    @if (session('delete_message'))
        <p class=" text-danger">{{ session('delete_message') }}</p>
    @endif
    @if (session('product_created_succ'))
        <p class=" text-success">{{ session('product_created_succ') }}</p>
    @endif
    <table class="table table-hover table-bordered table-striped text-center">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">name</th>
                <th scope="col">Price</th>
                <th scope="col">Image</th>
                <th colspan="2" scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($product as $item)
                <tr>
                    <th scope="row">{{ $item->id }}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->price }}</td>
                    <td><img width="200px" src="{{ asset('images/' . $item->img_path) }}" alt=""></td>
                    <td><a href="/edit/product/{{ $item->id }}">Edit</a></td>
                    <td><a href="/delete/product/{{ $item->id }}">Delete</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
