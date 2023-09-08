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
    <form method="POST" action="{{ url('import') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="csv_file">
        <button type="submit">Import CSV</button>
    </form>
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
