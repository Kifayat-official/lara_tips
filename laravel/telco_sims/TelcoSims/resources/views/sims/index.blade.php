@extends('auth.layouts')
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

    {{-- <form method="POST" action="{{ url('import') }}" enctype="multipart/form-data" id="upload-form">
        @csrf
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="csv_file" id="csv_file">
            <label class="custom-file-label" for="csv_file">Choose file</label>
        </div>
        <button type="button" class="btn btn-primary mt-3" id="submit-btn" disabled>Import CSV</button>
    </form> --}}

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
    <table class="table table-bordered">
        <tr>
            <th>Sr.#</th>
            <th>SIM ID</th>
            <th>SIM #</th>

            <th>TELCO</th>
            <th>DISCO</th>
            <th>PO #</th>
            <th>PO DATE</th>
            <th>SIM STATUS</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($sims as $sim)
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
        @endforeach
    </table>
    {!! $sims->links() !!}
@endsection

@section('footer-libs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#csv_file').change(function() {
                var fileInput = $(this);
                var submitButton = $('#submit-btn');

                if (fileInput[0].files.length > 0) {
                    submitButton.prop('disabled', false);
                } else {
                    submitButton.prop('disabled', true);
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
                        submitBtnContent.show();
                        submitBtnSpinner.hide();

                        resMsgTxt.text(data.message);
                        resMsgDiv.removeClass("d-none");

                        setTimeout(function() {
                            resMsgDiv.addClass("d-none");
                        }, 5000);
                    },
                    error: function(error) {
                        submitBtnContent.show();
                        submitBtnSpinner.hide();
                    }
                });
            });


        });
    </script>
@endsection
