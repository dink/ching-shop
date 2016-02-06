@extends('layouts.staff.dashboard')

@section('page-title')
    Products
@endsection

@section('header')
    All products
@endsection

@section('content')

    @if (count($products))
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>
                        SKU
                    </th>
                    <th>
                        Name
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>
                            <a href="{{ $location->showHrefFor($product) }}">
                                {{ $product->sku() }}
                            </a>
                        </td>
                        <td>
                            {{ $product->name() }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p>
        There are no products in the system. Would you like to
        <a href="{{ route('staff.products.create') }}">create one</a>?
    </p>
    @endif

@endsection