@extends('shared.dashboard')
@section('body')
<div class="card mt-3 mb-3">
    <div class="card-header">
        <div class="card-title">{{$o->id}}</div>
    </div>
    <div class="card-body">
        <table>
            <tr>
                <th>Ngày</th>
                <td>{{$o->created_at}}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{$o->phone}}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{{$o->address}},{{$o->ward_name}}</td>
            </tr>
        </table>
    </div>
</div>
<div class="bg-light border rounded-3 p-4 pt-2 pb-2">
  <div>
    <table class="table table-light mb-0" style="table-layout: fixed; width: 100%;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
            </thead>
    </table>
  </div>
  <div class="overflow-auto" style="max-height: 40vh;">
    <table class="table table-light table-hover" style="table-layout: fixed; width: 100%;">
            <tbody>
                @foreach($o->products as $v)
                    <tr>
                        <td>{{$v->name}}</td>
                        <td>
                            <img src="/{{$v->image}}" alt="{{$v->name}}" width="100">
                        </td>
                        <td>{{$v->price}}</td>
                        <td>{{$v->quantity}}</td>
                        <td>{{$v->price*$v->quantity}}</td>
                    </tr>
                @endforeach
            </tbody>
      </table>
  </div>
</div>
@endsection