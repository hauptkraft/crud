@extends('layouts.app')
@section('content')
<main class="container">
    <section>
        <div class="titlebar">
            <h1>Товары</h1>
            <a href="{{ route('products.create') }}" class="btn-link">Добавить</a>
        </div>
        @if ($message = Session::get('success'))
        <script type="text/javascript">
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: '{{$message}}'
            })
        </script>
        @endif
        <div class="table">
            <div class="table-filter">
                <div>
                    <ul class="table-filter-list">
                        <li>
                            <p class="table-filter-link link-active">Все</p>
                        </li>
                    </ul>
                </div>
            </div>

            <form method="GET" action="{{ route('products.index') }}" accept-charset="UTF-8" role="search">
                <div class="table-search">
                    <div>
                        <button class="search-select">
                            Поиск товара
                        </button>
                        <span class="search-select-arrow">
                            <i class="fas fa-caret-down"></i>
                        </span>
                    </div>
                    <div class="relative">
                        <input class="search-input" type="text" name="search" placeholder="Поиск..." value="{{ request('search') }}">
                    </div>
                </div>
            </form>

            <div class="table-product-head">

                <p></p>
                <p>Наименование</p>
                <p>Категория</p>
                <p>Штук</p>
                <p>Действия</p>
            </div>
            <div class="table-product-body">
                @if(count($products) > 0)
                @foreach ($products as $product)
                <img src="{{ asset('images/' . $product->image) }}" />
                <p>{{$product->name}}</p>
                <p>{{$product->category}}</p>
                <p>{{$product->quantity}}</p>
                <div>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-success">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <form method="post" action="{{ route('products.destroy', $product->id) }}">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger" onclick="deleteConfirm(event)">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
                @endforeach
                @else
                <p>Товары не найдены</p>
                @endif

            </div>
            <div class="table-paginate">
                {{$products->links('layouts.pagination')}}
            </div>
        </div>
    </section>
</main>
<script>
    window.deleteConfirm = function(e) {
        e.preventDefault();
        var form = e.target.form;
        // sweetalert
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        })
    }
</script>
@endsection