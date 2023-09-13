@extends('sims.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Sim</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('sims.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('sims.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Sim Id:</strong>
                    <input type="text" name="sim_id" value="{{ isset($sim) ? $sim->sim_id : old('sim_id') }}"
                        class="form-control" placeholder="SIM ID">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Sim #:</strong>
                    <input type="text" name="sim_no" value="{{ isset($sim) ? $sim->sim_no : old('sim_no') }}"
                        class="form-control" placeholder="SIM #">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Telco Name:</strong>
                    <select name="telco_name" class="form-control">
                        <option value="" {{ old('telco_name') === null ? 'selected' : '' }}>Select Telco</option>
                        <option value="ufone"
                            {{ isset($sim) && $sim->telco_name == 'ufone' ? 'selected' : (old('telco_name') == 'ufone' ? 'selected' : '') }}>
                            Ufone
                        </option>
                        <option value="zong"
                            {{ isset($sim) && $sim->telco_name == 'zong' ? 'selected' : (old('telco_name') == 'zong' ? 'selected' : '') }}>
                            Zong
                        </option>
                        <option value="telenor"
                            {{ isset($sim) && $sim->telco_name == 'telenor' ? 'selected' : (old('telco_name') == 'telenor' ? 'selected' : '') }}>
                            Telenor
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Disco Name:</strong>
                    <select name="disco_name" class="form-control">
                        <option value="" {{ old('disco_name') === null ? 'selected' : '' }}>Select DISCO</option>
                        <option value="mepco"
                            {{ isset($sim) && $sim->disco_name == 'mepco' ? 'selected' : (old('disco_name') == 'mepco' ? 'selected' : '') }}>
                            MEPCO
                        </option>
                        <option value="iesco"
                            {{ isset($sim) && $sim->disco_name == 'iesco' ? 'selected' : (old('disco_name') == 'iesco' ? 'selected' : '') }}>
                            IESCO
                        </option>
                        <option value="pesco"
                            {{ isset($sim) && $sim->disco_name == 'pesco' ? 'selected' : (old('disco_name') == 'pesco' ? 'selected' : '') }}>
                            PESCO
                        </option>
                        <option value="hesco"
                            {{ isset($sim) && $sim->disco_name == 'hesco' ? 'selected' : (old('disco_name') == 'hesco' ? 'selected' : '') }}>
                            HESCO
                        </option>
                        <option value="fesco"
                            {{ isset($sim) && $sim->disco_name == 'fesco' ? 'selected' : (old('disco_name') == 'fesco' ? 'selected' : '') }}>
                            FESCO
                        </option>
                        <option value="gepco"
                            {{ isset($sim) && $sim->disco_name == 'gepco' ? 'selected' : (old('disco_name') == 'gepco' ? 'selected' : '') }}>
                            GEPCO
                        </option>
                        <option value="sepco"
                            {{ isset($sim) && $sim->disco_name == 'sepco' ? 'selected' : (old('disco_name') == 'sepco' ? 'selected' : '') }}>
                            SEPCO
                        </option>
                        <option value="qesco"
                            {{ isset($sim) && $sim->disco_name == 'qesco' ? 'selected' : (old('disco_name') == 'qesco' ? 'selected' : '') }}>
                            QESCO
                        </option>
                        <option value="tesco"
                            {{ isset($sim) && $sim->disco_name == 'tesco' ? 'selected' : (old('disco_name') == 'tesco' ? 'selected' : '') }}>
                            TESCO
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>PO #:</strong>
                    <input type="text" name="po_no" value="{{ isset($sim) ? $sim->po_no : old('po_no') }}"
                        class="form-control" placeholder="PO #">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>PO Date:</strong>
                    <input type="date" name="po_date" value="{{ isset($sim) ? $sim->po_date : old('po_date') }}"
                        class="form-control" placeholder="PO Date">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>SIM Status:</strong>
                    <select name="status" id="status" class="form-control">
                        <option value="">Select Status</option>
                        <option value="0"
                            {{ isset($sim) && $sim->status == '0' ? 'selected' : (old('status') == '0' ? 'selected' : '') }}>
                            In-Active</option>
                        <option value="1"
                            {{ isset($sim) && $sim->status == '1' ? 'selected' : (old('status') == '1' ? 'selected' : '') }}>
                            Active
                        </option>
                    </select>
                </div>
            </div>

            <input type="hidden" name="rec_id" value="{{ isset($sim) ? $sim->id : old('rec_id') }}">

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection
