@extends('customer.front')

@section('page-title')
    Basket ({{ $basket->basketItems->count() }}
    {{ str_plural('item', $basket->basketItems->count()) }})
@endsection

@section('body')

    @include('flash::message')

    <h1 class="basket-title">
        <span class="glyphicon glyphicon-shopping-cart"></span>
        Your shopping basket
        ({{ $basket->basketItems->count() }}
        {{ str_plural('item', $basket->basketItems->count()) }})
    </h1>

    <table class="table table-striped table-condensed">
        @foreach ($basket->basketItems as $basketItem)
            <tr>
                <td>
                    <a href="{{ route('product::view', [
                            $basketItem->productOption->product->id,
                            $basketItem->productOption->product->slug,
                        ]) }}">
                        {{ $basketItem->productOption->product->name }}
                        <strong>
                            ({{ $basketItem->productOption->label }})
                        </strong>
                    </a>
                </td>
                <td>
                    @if ($basketItem->productOption->images->first())
                        <a href="{{ route('product::view', [
                            $basketItem->productOption->product->id,
                            $basketItem->productOption->product->slug,
                        ]) }}">
                    <img src="{{ $basketItem->productOption->images->first()->sizeUrl('small') }}"
                         class="basket-product-image"/>
                        </a>
                    @endif
                </td>
                <td class="basket-item-price">
                    {{ $basketItem->productOption->product->price() }}
                </td>
                <td>
                    <form method="post"
                          action="{{ route('sales.customer.remove-from-basket') }}">
                        {{ csrf_field() }}
                        <input name="basket-item-id"
                               value="{{ $basketItem->id }}"
                               type="hidden" />
                        <button type="submit" class="btn btn-link btn-sm">
                            <span class="glyphicon glyphicon-remove"></span>
                            <span class="sr-only">
                                Remove
                                {{ $basketItem->productOption->product->name }}
                            </span>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection