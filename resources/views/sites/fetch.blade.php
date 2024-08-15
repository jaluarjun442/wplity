@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Fetch Posts => {{ $site->name }} => ( Last Updated Fetch of =>{{ $site->last_updated_fetch }})</div>

                <div class="card-body">
                    <form id="fetchForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id" name="id" value="{{$site->id}}" />
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="last_updated_fetch">Last Updated Fetch</label>
                                <input type="text" name="last_updated_fetch" id="last_updated_fetch" class="form-control @error('last_updated_fetch') is-invalid @enderror" value="{{ old('last_updated_fetch', $site->last_updated_fetch) }}">
                                @error('last_updated_fetch')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="last_updated_api_send">Last Updated Fetch</label>
                                <input type="text" name="last_updated_api_send" id="last_updated_api_send" class="form-control @error('last_updated_api_send') is-invalid @enderror" value="{{ old('last_updated_api_send', $site->last_updated_api_send) }}">
                                @error('last_updated_api_send')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="api_send_url">Api Send URL</label>
                                <input type="text" name="api_send_url" id="api_send_url" class="form-control @error('api_send_url') is-invalid @enderror" 
                                value="{{ old('api_send_url', $site->api_send_url) }}">
                                @error('api_send_url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button" id="fetchButton" class="btn btn-primary">Fetch</button>
                            <button type="button" id="api_send_button" class="btn btn-primary">Api Send</button>
                        </div>
                        <div class="form-group">
                            <div class="alert alert-info" id="loadingIndicator" style="display:none;">Loading...</div>
                            <div class="response_status">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ $site->description }}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page_scripts')
<script>
    $(document).ready(function() {
        $('#api_send_button').click(function(e) {
            e.preventDefault();

            var formData = new FormData($('#fetchForm')[0]);
            // $('#api_send_button').prop('disabled', true);
            $('#loadingIndicator').show();
            $.ajax({
                url: "{{ route('sites.api_send_data') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == true) {
                        var alertHtml = `
                            <div class="alert alert-success">
                                <div>
                                    ${response.message}===
                                    (Current Page=>${response.current_page})===
                                    (Total Pages=>${response.total_pages})===
                                    (Total Posts=>${response.total_post})===
                                    (Next Page Available=>${response.next_page ? 'Yes' : '<b style="color:red;">No</b>'})===
                                </div>
                                <div>
                                    (Last Updated Fetched=>${response.last_updated_fetch})===
                                </div>
                            </div>
                            `;
                    } else {
                        var alertHtml = `
                            <div class="alert alert-danger">
                                ${response.message}
                            </div>
                            `;
                    }

                    $('.response_status').prepend(alertHtml);
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var errorHtml = '<div class="alert alert-danger"><ul>';

                    $.each(errors, function(key, value) {
                        errorHtml += '<li>' + value[0] + '</li>';
                    });

                    errorHtml += '</ul></div>';
                    $('.response_status').html(errorHtml);
                },
                complete: function() {
                    // $('#api_send_button').prop('disabled', false);
                    $('#loadingIndicator').hide();
                }
            });
        });
        $('#fetchButton').click(function(e) {
            e.preventDefault();

            var formData = new FormData($('#fetchForm')[0]);
            $('#fetchButton').prop('disabled', true);
            $('#loadingIndicator').show();
            $.ajax({
                url: "{{ route('sites.fetch_data') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == true) {
                        var alertHtml = `
                            <div class="alert alert-success">
                                <div>
                                    ${response.message}===
                                    (Current Page=>${response.current_page})===
                                    (Total Pages=>${response.total_pages})===
                                    (Total Posts=>${response.total_post})===
                                    (Next Page Available=>${response.next_page ? 'Yes' : '<b style="color:red;">No</b>'})===
                                </div>
                                <div>
                                    (Last Updated Fetched=>${response.last_updated_fetch})===
                                </div>
                            </div>
                            `;
                    } else {
                        var alertHtml = `
                            <div class="alert alert-danger">
                                ${response.message}
                            </div>
                            `;
                    }

                    $('.response_status').prepend(alertHtml);
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var errorHtml = '<div class="alert alert-danger"><ul>';

                    $.each(errors, function(key, value) {
                        errorHtml += '<li>' + value[0] + '</li>';
                    });

                    errorHtml += '</ul></div>';
                    $('.response_status').html(errorHtml);
                },
                complete: function() {
                    $('#fetchButton').prop('disabled', false);
                    $('#loadingIndicator').hide();
                }
            });
        });
    });
</script>
@endsection