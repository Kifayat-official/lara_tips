<div class="form-group {{$class}}">
    <label for="">{{$title}}</label>
    <input type="text" class="form-control datetimepicker-field" name="{{$name}}" 
        value="{{$value}}">
</div>

<script>
    $(document).ready(function(){
        $('.datetimepicker-field').datetimepicker({
            'format': 'DD-MMM-YYYY HH:mm:ss',
        });
    });
</script>