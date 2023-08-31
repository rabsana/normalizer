@extends(config('rabsana-normalizer.views.master-layout'))
@section("title"){{__("cryptocurrencies")}}@endsection

@push(config('rabsana-normalizer.views.styles-stack'))
@endpush

@push(config('rabsana-normalizer.views.scripts-stack'))
    <script>
        $('form.delete-normalizer-form').on("submit", function (e) {
            e.preventDefault();
            var form = $(this);

            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function () {
                    form.parents('tr').remove();
                }
            });

        });

    </script>
@endpush

@section(config('rabsana-normalizer.views.content-section'))
    <div class="row">
        <div class="col-12 mb-1 pl-1">
            <a href="{{ route('rabsana_normalizer.normalizers.create') }}" class="btn btn-success"><i
                        class="fas fa-plus"></i>&nbsp;{{ trans('rabsana-normalizer::messages.create_new_normalizer') }}
            </a>
        </div>
        <div class="col-lg-12 portlets">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h3 class="card-title"
                        style="font-weight: 400;">
                        @if(isset($user))
                            {{ trans('rabsana-normalizer::messages.normalizers_list_for_user', ['user' => $user->name]) }}
                        @else
                            {{ trans('rabsana-normalizer::messages.normalizers_list') }}
                        @endif
                    </h3>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                        </ul>
                    </div>
                </div>

                <div class="card-body collapse in card-block table-responsive">
                    @if(session('delete_success'))
                        <div class="alert alert-success">@lang('item_successfully_removed')</div>
                    @endif
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('rabsana-normalizer::messages.user') }}</th>
                            <th>{{ trans('rabsana-normalizer::messages.for') }}</th>
                            <th>{{ trans('rabsana-normalizer::messages.from') }}</th>
                            <th>{{ trans('rabsana-normalizer::messages.to') }}</th>
                            <th>{{ trans('rabsana-normalizer::messages.ratio') }}</th>
                            <th>{{ trans('rabsana-normalizer::messages.status') }}</th>
                            <th><i class="fas fa-wrench"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($normalizers as $normalizer)
                            <tr>
                                <td>{{ $normalizer->id }}</td>
                                <td>
                                    <span>{{ $normalizer->user_name }}</span>
                                </td>
                                <td>{{ $normalizer->normalizable->name }}</td>
                                <td>{{ $normalizer->from }}</td>
                                <td>{{ $normalizer->to }}</td>
                                <td>{{ $normalizer->ratio }}</td>
                                <td>{{ $normalizer->active ? trans('rabsana-normalizer::messages.active') : trans('rabsana-normalizer::messages.disabled') }}</td>
                                <td>
                                    <a href="{{ route('rabsana_normalizer.normalizers.edit', $normalizer->id) }}"
                                       class="btn btn-info btn-sm">{{ trans('rabsana-normalizer::messages.edit') }}</a>
                                    <form class="d-inline delete-normalizer-form" method="post"
                                          action="{{ route('rabsana_normalizer.normalizers.destroy', $normalizer->id) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
