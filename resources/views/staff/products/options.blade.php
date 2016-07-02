<div class="table-responsive"
     id="product-options"
     data-product-id="{{ $product->id }}">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>
                Label
            </th>
            <th>
                Colour
            </th>
            <th>
                Images
            </th>
            <th>
                Stock
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($product->options as $option)
            <tr>
                <td>
                    <p contenteditable="true"
                       data-option-id="{{ $option->id }}"
                       data-original="{{ $option->label }}"
                       class="product-option-label js-only hidden">
                        {{ $option->label }}
                    </p>
                </td>
                <td>
                    <form method="post"
                          id="option-{{$option->id}}-colour-form"
                          class="form-inline"
                          action="{{ route(
                            'staff.products.options.put-colour',
                            [$option->id]
                          ) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group form-group-sm">
                            <label for="option-{{$option->id}}-colour"
                                   class="sr-only">
                                Select colour
                            </label>
                            <select class="form-control"
                                    name="colour"
                                    id="option-{{$option->id}}-colour">
                                @foreach ($colours as $colour)
                                    <option id="colour-option-{{ $colour->id }}"
                                            @if ($option->hasColour($colour->id))
                                            selected
                                            @endif
                                            value="{{ $colour->id }}">
                                        {{ $colour->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-sm btn-default"
                                type="submit"
                                id="set-option-{{ $colour->id }}-colour"
                                form="option-{{$option->id}}-colour-form">
                            Set colour
                        </button>
                    </form>
                </td>
                <td>
                    @include('staff.products.images', ['parent' => $option])
                </td>
                <td>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<hr>

<div class="well">
    <form method="post"
          id="new-option-form"
          class="form-inline"
          action="{{ route(
                 'staff.products.post-option',
                  ['id' => $product->id]
              ) }}">
        {{ csrf_field() }}
        {{ method_field('POST') }}
        <div class="form-group">
            <label for="new-option">
                Add new option
            </label>
            <input type="text"
                   class="form-control"
                   name="label"
                   minlength="2"
                   maxlength="127"
                   required="required"
                   placeholder="Label..."
                   id="new-option"/>
            <input type="hidden"
                   required="required"
                   id="option-product"
                   name="option-product"
                   value="{{ $product->id }}"/>
        </div>
        <button type="submit"
                form="new-option-form"
                id="new-option-button"
                class="btn btn-success">
            <span class="glyphicon glyphicon-plus"></span>
            Add option
        </button>
        @foreach($reply->errorsFor('label') as $error)
            <label class="help-block" for="label">
                {{ $error }}
            </label>
        @endforeach
    </form>
</div>

@push('scripts')
<script async defer
        type="text/javascript"
        src="{{ elixir('js/product-options.js') }}">
</script>
@endpush
