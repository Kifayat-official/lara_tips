@extends('auth.layouts')
@section('header-libs')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
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
        {{-- @foreach ($sims as $sim)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $sim->sim_no }}</td>
                <td>{{ $sim->sim_id }}</td>
                <td>{{ $sim->telco_name }}</td>
                <td>{{ $sim->disco_name }}</td>
                <td>{{ $sim->po_no }}</td>
                <td>{{ $sim->po_date }}</td>
                <td>
                    <span class="badge {{ $sim->status == 1 ? 'bg-success' : 'bg-danger' }}">
                        {{ $sim->status == 1 ? 'Active' : 'In-Active' }}
                    </span>
                </td>
                <td>
                    <form action="{{ route('sims.destroy', $sim->id) }}" method="POST">

                        <a class="btn btn-primary" href="{{ route('sims.edit', $sim->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach --}}

        {{-- {!! $sims->links() !!} --}}
        </div>
    @endsection

    @section('footer-libs')
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
        <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

        <script>
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
