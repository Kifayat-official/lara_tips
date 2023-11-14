<div class="table-responsive">
    <table id="table_{{$uniqid}}" class="table table-bordered">
        <thead>

            <?php
                $is_filters_set = false;
            ?>

            <tr>
                @foreach($columns as $column)
                    <th class="{{ isset($column['class']) ? $column['class'] : '' }}">{{$column['title']}}</th>
                    <?php
                        if(isset($column['filter_options'])) 
                        {
                            $is_filters_set = true;
                        }
                    ?>
                @endforeach
            </tr>

            @if($is_filters_set)
                <tr class="bg-info">
                    @foreach($columns as $column)
                        <td>
                            @if(isset($column['filter_options']))
                                @if($column['filter_options']['type'] == 'select')
                                    <select class="filter-control" style="width: 100%;" class="form-control" data-relation_and_column="{{$column['filter_options']['relation_and_column']}}">
                                        <option value="">All</option>
                                        @foreach($column['filter_options']['select_options'] as $value => $title)
                                        <option value="{{$value}}">{{$title}}</option>
                                        @endforeach
                                    </select>
                                @endif
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endif

        </thead>

        <tbody>
        </tbody>
    </table>
</div>

@section('js')
<script>
    $(document).ready(function() {

        $('.filter-control').change(function(){
            refreshDataTable();
        })

        var table_{{$uniqid}} = $('#table_{{$uniqid}}').DataTable({
            processing: true,
            serverSide: true,
            bSortCellsTop: true,
            ajax: {
                url: '{{$data_url}}',
                type: 'post',
                data: function(d) {
                    d['_token'] = "{{@csrf_token()}}";

                    var filters = [];

                    $.each( $('.filter-control'), function(index, item){
                        if( $(item).val() ) {
                            filters.push({
                                relation_and_column: $(item).data('relation_and_column'),
                                value: $(item).val(),
                            });
                        }
                    });

                    if(filters.length > 0) {
                        d['filters'] = filters;
                    }

                    return d;
                }
            },
            columns: [

                @foreach($columns as $column) {
                    data: '{{$column["data"]}}',
                    name: '{{$column["name"]}}',
                    defaultContent: '-',
                    class: '{{isset($column["class"]) ? $column["class"] : "" }}'
                },
                @endforeach

            ]
        });

        function refreshDataTable() {
            table_{{$uniqid}}.ajax.reload();
        }
    });

    function editItem(id) {
        window.location.href = "{{$resource_url}}" + "/" + id + "/edit";
    }

    function deleteItem(id, deleteButton) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {

            if (result.value) {

                $.ajax({
                    url: '{{$resource_url}}' + '/' + id,
                    type: 'post',
                    data: {
                        _token: "{{@csrf_token()}}",
                        _method: 'DELETE',
                    },
                }).done(function(data) {
                    $(deleteButton).closest('tr').remove();
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }).fail(function(error) {
                    alert(error);
                });
            }
        });
    }
</script>
@endsection