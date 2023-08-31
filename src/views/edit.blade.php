@extends(config('rabsana-normalizer.views.master-layout'))

@push(config('rabsana-normalizer.views.styles-stack'))
  <style>
    .d-none {
      display: none !important;
    }

    #edit-normalizer-button.loading {

    }
  </style>
@endpush

@push(config('rabsana-normalizer.views.scripts-stack'))
  <script>
      $('select[name="normalizable_type"]').on('change', function (e) {

          var counter = $(this).find('option:selected').data('counter');

          $('select[name="normalizable_id"] option[data-counter]').addClass('d-none');
          $('select[name="normalizable_id"] option[data-counter="' + counter + '"]').removeClass('d-none');

          $('select[name="prop"] option[data-counter]').addClass('d-none');
          $('select[name="prop"] option[data-counter="' + counter + '"]').removeClass('d-none');
      });

      $('#edit-normalizer-button').on('click', function (e) {
          e.preventDefault();

          var button = $(this);
          button.addClass('loading');
          var form = $('form#edit-normalizer-form');

          $.ajax({
              type: form.attr('method'),
              url: form.attr('action'),
              data: form.serialize(), // serializes the form's elements.
              success: function (data) {
                  $('.rabsana-normalizer.alert.alert-success').removeClass('d-none');
                  setTimeout(function () {
                      $('.rabsana-normalizer.alert.alert-success').addClass('d-none')
                  }, 5000);
              },
              error: function (data) {
                  var errors = data.responseJSON.errors;
                  var html = '<ul>';
                  Object.keys(errors).map(function (key) {
                      errors[key].forEach(function (o, i) {
                          html += '<li>';
                          html += o;
                          html += '</li>';
                      });
                  });
                  html += '</ul>';
                  $('.rabsana-normalizer.alert.alert-danger .alert-body').html(html);
                  $('.rabsana-normalizer.alert.alert-danger').removeClass('d-none');
                  window.scrollTo({
                    top: 100,
                    left: 0,
                    behavior: 'smooth'
                  });
                  setTimeout(function () {
                      $('.rabsana-normalizer.alert.alert-danger').addClass('d-none')
                  }, 5000);
              },
              complete(b, c) {
                  button.removeClass('loading');
              }
          });
      });
  </script>
@endpush

@section(config('rabsana-normalizer.views.content-section'))
  <div class="row">
    <div class="col-12 mb-1 pl-1">
      <a href="{{ route('rabsana_normalizer.normalizers.index') }}" class="btn btn-info"><i class="fas fa-list"></i>&nbsp;{{ trans('rabsana-normalizer::messages.normalizers_list') }}
      </a>
    </div>
    <div class="col-lg-12 portlets">
      <div class="card">
        <div class="card-header bg-dark text-white">
          <h3 class="card-title"
              style="font-weight: 400;">{{ trans('rabsana-normalizer::messages.create_new_normalizer') }}</h3>
          <div class="heading-elements">
            <ul class="list-inline mb-0">
              <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
            </ul>
          </div>
        </div>

        <div class="card-body collapse in card-block table-responsive">
          <div class="row">
            <div class="col-12 col-lg-4 mx-auto">
              <div class="rabsana-normalizer alert alert-danger d-none" role="alert">
                <strong>{{ trans('rabsana-normalizer::messages.error') }}!</strong>
                <div class="alert-body"></div>
              </div>
              <div class="rabsana-normalizer alert alert-success d-none" role="alert">
                <strong>{{ trans('rabsana-normalizer::messages.success') }}</strong>
                <div class="alert-body">{{ trans('rabsana-normalizer::messages.item_edited_successfully') }}</div>
              </div>
              <form id="edit-normalizer-form"
                    action="{{ route("rabsana_normalizer.normalizers.update", $normalizer->id) }}" method="post">
                {{csrf_field()}}
                {{ method_field('PUT') }}

                <div class="form-group">
                  <label
                         class="control-label">{{ trans('rabsana-normalizer::messages.user') }}</label>
                  <p>{{ $normalizer->user_name }}</p>
                </div>
                <div class="form-group">
                  <label for="rabsana-normalizer-normalizable-type"
                         class="control-label">{{ trans('rabsana-normalizer::messages.normalizable_type') }}</label>
                  <select name="normalizable_type" id="rabsana-normalizer-normalizable-type" class="form-control">
                    <option value="" selected disabled="">@lang('choose_option')</option>
                    @foreach($templates as $template)
                      <option value="{{ $template['class'] }}" data-counter="{{ $loop->iteration }}"
                              @if($template['class'] == $normalizer->normalizable_type) selected @endif>{{ $template['name'] }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="rabsana-normalizer-normalizable-id"
                         class="control-label">{{ trans('rabsana-normalizer::messages.normalizable_id') }}</label>
                  <select name="normalizable_id" id="rabsana-normalizer-normalizable-id" class="form-control">
                    <option value="" selected disabled="">@lang('choose_option')</option>
                    @foreach($templates as $template)
                      @foreach($template['records'] as $record)
                        <option @if($template['class'] != $normalizer->normalizable_type) class="d-none"
                                @endif @if($record->id == $normalizer->normalizable_id) selected
                                @endif value="{{ $record->id }}"
                                data-counter="{{ $loop->parent->iteration }}">{{ $record->name }}</option>
                      @endforeach
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="rabsana-normalizer-prop"
                         class="control-label">{{ trans('rabsana-normalizer::messages.prop') }}</label>
                  <select name="prop" id="rabsana-normalizer-prop" class="form-control">
                    <option value="" selected disabled="">@lang('choose_option')</option>
                    @foreach($templates as $template)
                      @foreach($template['normalizations'] as $prop => $title )
                        <option @if($template['class'] != $normalizer->normalizable_type) class="d-none"
                                @endif @if($prop == $normalizer->prop) selected @endif value="{{ $prop }}"
                                data-counter="{{ $loop->parent->iteration }}">{{ $title }}</option>
                      @endforeach
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="rabsana-normalizer-from"
                         class="control-label">{{ trans('rabsana-normalizer::messages.from') }}</label>
                  <input type="text" value="{{ $normalizer->from }}" name="from" id="rabsana-normalizer-from"
                         class="form-control">
                </div>
                <div class="form-group">
                  <label for="rabsana-normalizer-to"
                         class="control-label">{{ trans('rabsana-normalizer::messages.to') }}</label>
                  <input type="text" value="{{ $normalizer->to }}" name="to" id="rabsana-normalizer-to"
                         class="form-control">
                </div>
                <div class="form-group">
                  <label for="rabsana-normalizer-ratio"
                         class="control-label">{{ trans('rabsana-normalizer::messages.ratio') }}</label>
                  <input type="text" value="{{ $normalizer->ratio }}" name="ratio" id="rabsana-normalizer-ratio"
                         class="form-control">
                </div>
                <div class="form-group">
                  <label for="rabsana-normalizer-active"
                         class="control-label">{{ trans('rabsana-normalizer::messages.active') }} <input type="radio"
                                                                                                         name="active"
                                                                                                         id="rabsana-normalizer-active"
                                                                                                         class="form-control"
                                                                                                         value="1"
                                                                                                         @if($normalizer->active) checked @endif></label>
                  <label for="rabsana-normalizer-disabled"
                         class="control-label">{{ trans('rabsana-normalizer::messages.disabled') }} <input type="radio"
                                                                                                           name="active"
                                                                                                           id="rabsana-normalizer-disaled"
                                                                                                           class="form-control"
                                                                                                           value="0"
                                                                                                           @if(!$normalizer->active) checked @endif></label>
                </div>
                <button class="btn btn-info" type="button"
                        id="edit-normalizer-button">{{ trans('rabsana-normalizer::messages.edit') }}</button>
                <a class="btn btn-secondary"
                   href="{{ route('rabsana_normalizer.normalizers.index') }}">{{ trans('rabsana-normalizer::messages.cancel') }}</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
