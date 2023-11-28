
<div>
    <div>
        <h1>{{$data['title']}}</h1>
        <p>You order id: {{$data['content']['InvoiceId']}}</p>
    </div>
    <div>
        <table>
            <tr>
                <th>Ngày</th>
                <td>{{$data['content']['created_at']}}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{$data['content']['Phone']}}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{{$data['content']['Address']}}</td>
            </tr>
        </table>
    </div>
</div>
<div>
    <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Size</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
            </thead>
   <tbody>
                @foreach($data['content']['product'] as $v)
                    <tr>
                        <td>{{$v['ProductName']}}</td>
                        <td>
                        <img src="{{ $message->embed(public_path() . "/images/product/{$v['ImageUrl']}") }}" width="100">
                        </td>
                        <td>{{$v['Size']}}</td>
                        <td>{{$v['Price']}}</td>
                        <td>{{$v['Amount']}}</td>
                        <td>{{$v['Price']*$v['Amount']}}</td>
                    </tr>
                @endforeach
            </tbody>
      </table>
</div>
<div>
    <b>Tổng thanh toán: {{$data['content']['TotalAll']}}</b>
</div>
