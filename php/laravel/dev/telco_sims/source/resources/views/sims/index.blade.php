@extends('auth.layouts')
@section('header-libs')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet"> --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>SIMS Database</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('sims.create') }}"> Create New SIM</a>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ url('import') }}" enctype="multipart/form-data" id="upload-form">
        @csrf
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="csv_file" id="csv_file" required>
            <label class="custom-file-label" for="csv_file">Choose file</label>
        </div>
        <button type="button" class="btn btn-primary mt-3" id="submit-btn" disabled>
            <span id="submit-btn-content">Import CSV</span>
            <div id="submit-btn-spinner" style="display: none;">
                <div class="spinner-border spinner-border-sm" role="status"></div>
                <span class="sr-only">Loading...</span>
            </div>
        </button>
        <div class="invalid-feedback">Please attach a CSV file.</div>
    </form>
    <div id="res-msg" class="alert alert-success d-none">
        <p id="res-msg-txt"></p>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th width="280px">Sr.#</th>
                <th>Sim #</th>
                <th>Msn #</th>
                <th>Telco</th>
                <th>Disco</th>
                <th>PO #</th>
                <th>PO Date</th>
                <th>Sim Status</th>
                <th>Action</th>
            </tr>
        </thead>
        </div>
    @endsection

    @section('footer-libs')
        {{-- <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
        <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script> --}}

        <script type="text/javascript">
            $(document).ready(function() {

                var submitButton = $('#submit-btn');
                submitButton.addClass("d-none");

                $('#csv_file').change(function() {
                    var fileInput = $(this);
                    if (fileInput[0].files.length > 0) {
                        submitButton.prop('disabled', false);
                        submitButton.removeClass("d-none");
                    } else {
                        submitButton.addClass("d-none");
                        // submitButton.prop('disabled', true);
                    }
                });

                $('#submit-btn').click(function() {
                    var submitBtnContent = $('#submit-btn-content')
                    var submitBtnSpinner = $('#submit-btn-spinner')
                    var resMsgDiv = $('#res-msg')
                    var resMsgTxt = $('#res-msg-txt')
                    submitBtnContent.hide()
                    submitBtnSpinner.show()
                    var formData = new FormData($('#upload-form')[0])

                    $.ajax({
                        url: "{{ url('import') }}",
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            submitButton.addClass("d-none");
                            submitBtnContent.show();
                            submitBtnSpinner.hide();
                            resMsgDiv.removeClass("d-none");
                            resMsgTxt.text(data.message);
                        },
                        error: function(error) {
                            submitBtnContent.show();
                            submitBtnSpinner.hide();
                        }
                    });

                });
            });
        </script>

        {{-- Datatable --}}
        <script type="text/javascript">
            $(function() {

                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('sims.index') }}",
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'sim_no',
                            name: 'sim_no'
                        },
                        {
                            data: 'msn_no',
                            name: 'msn_no'
                        },
                        {
                            data: 'telco_name',
                            name: 'telco_name'
                        },
                        {
                            data: 'disco_name',
                            name: 'disco_name'
                        },
                        {
                            data: 'po_no',
                            name: 'po_no'
                        },
                        {
                            data: 'po_date',
                            name: 'po_date'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });

            });
        </script>
    @endsection
