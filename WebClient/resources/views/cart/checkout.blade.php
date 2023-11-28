@extends('shared.layout')
@section('body')
<div style="display: flex; align-items: center;">
  <h4 class="fw-bold text-light mt-2 mb-3 p-0">Order</h4>
  <hr class="text-light" style="flex-grow: 1; margin-left: 10px;">
</div>
<a href="/cart" class="btn btn-primary rounded-pill bg-warning text-dark mt-2">Back to cart</a>
<div class="row mt-3">
    <div class="col-3">
        <form method="POST" class="border rounded shadow-lg p-3" action="/invoice/add">
            @csrf
            <div>
                <label class="d-block text-light">
                    Phone
                </label>
                <input class="form-control" type="tel" name="Phone" minlength="10" maxlength="11">
            </div>
            <div>
                <label class="d-block text-light">Province</label>
                <select name="Province_id" class="form-select">
                @foreach($lct as $province_id => $province)
                    <option value="{{$province_id}}">{{$province['name']}}</option>
                @endforeach
            </select>
            </div>
            <div>
                <label class="d-block text-light" for="">District</label>
                <select name="District_id" class="form-select">
                    @foreach($lct as $province)
                        @foreach($province['districts'] as $district_id => $district)
                            <option value="{{$district_id}}">{{$district['name']}}</option>
                        @endforeach
                    @endforeach
                </select>
            </div>
            <div>
                <label class="d-block text-light" for="">Ward</label>
                <select name="Wards_id" class="form-select">
                    @foreach($lct as $province)
                        @foreach($province['districts'] as $district)
                            @foreach($district['wards'] as $ward)
                                <option value="{{$ward['wards_id']}}">{{$ward['name']}}</option>
                            @endforeach
                        @endforeach
                    @endforeach
                </select>
            </div>
            <div>
                <label class="d-block text-light" for="">Address</label>
                <input class="form-control" type="text" name="Address" required>
            </div>
            <button class="mt-3 rounded-pill btn-success bg-warning text-dark"><i class="bi bi-truck"></i></button>
        </form>
    </div>
    
<div class="col-9 bg-light border rounded-3 p-4 pt-2 pb-2">
<div>
    <table class="table table-light mb-0" style="table-layout: fixed; width: 100%;">
        <thead>
            <tr class="text-center" style="width: fit-content;">
                <th>ProductName</th>
                <th>Image</th>
                <th>Size</th>
                <th>Price</th>
                <th>Amount</th>
                <th>Total Price</th>
            </tr>
        </thead>
    </table>
  </div>
  <div class="overflow-auto" style="max-height: 53vh;">
    <table class="table table-light table-hover" style="table-layout: fixed; width: 100%;">
            <tbody>
                @if(isset($msg))
                <td class="text-center">{{$msg}}</td>
                @else
                    @php
                        $total=0;
                    @endphp
                    @foreach($cart as $v)
                    <tr class="text-center"  style="width: fit-content;">
                        <td>{{$v['ProductName']}}</td>
                        <td><img src="/images/product/{{$v['ImageUrl']}}" alt="{{$v['ProductName']}}" width="100"></td>
                        <td>{{$v['Size']}}</td>
                        <td>{{$v['Price']}}</td>
                        <td>{{$v['Amount']}}</td>
                        <td>{{$v['Price'] * $v['Amount']}}</td>
                    </tr>
                    @php
                        $total+=$v['Price'] * $v['Amount'];
                    @endphp
                    @endforeach
                @endif
            </tbody>
      </table>
  </div>
  <div class="mt-2">
    Total order price: {{$total}}
    </div>
</div>
</div>
@section('scripts')
<script>
    var lct = <?php echo json_encode($lct); ?>;
    $(document).ready(function() {
    //$('select[name="Province_id"]').trigger('change');
    $('select[name="Province_id"]').on('change', function() {
    var provinceId = $(this).val();
    var districts = lct[provinceId]['districts'];
    $('select[name="District_id"]').empty();
    $.each(districts, function(districtId, district) {
        $('select[name="District_id"]').append('<option value="' + districtId + '">' + district['name'] + '</option>');
    });
    // Gọi sự kiện 'change' cho 'District_id' ngay sau khi đã cập nhật các tùy chọn cho nó
    $('select[name="District_id"]').trigger('change');
});

$('select[name="District_id"]').on('change', function() {
    var provinceId = $('select[name="Province_id"]').val();
    var districtId = $(this).val();
    var wards = lct[provinceId]['districts'][districtId]['wards'];
    $('select[name="Wards_id"]').empty();
    $.each(wards, function(index, ward) {
        $('select[name="Wards_id"]').append('<option value="' + ward['wards_id'] + '">' + ward['name'] + '</option>');
    });
});

    
});
$(document).ready(function() {
    $('form').on('submit', function(event) {
        event.preventDefault();
        var form_data = $(this).serialize(); 
        $.ajax({
            url: '/invoice/add',
            method: 'POST',
            data: form_data,
            success: function(data) {
                console.log(data);
                if(data.success){
                    alert('Order successfully!');
                    // window.location.href='/invoice';
                }
                else
                    alert(data.error);
            },
            error: function(error) {
                console.log(error);
                alert(error.responseJSON.message);
            }
        });
    });
});
</script>
@endsection
@endsection