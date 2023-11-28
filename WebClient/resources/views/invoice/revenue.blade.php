@extends('shared.layout')
@section('body')
@section('title','Revenue')
@csrf
<div class="container bg-light rounded ">
        <div class="row">
            <div id="myexChart" class="col-sm-12 col-md-6 col-lg-4 border-end d-flex align-items-center">
                <canvas id="myChart" style="width:100%;max-width:500px"></canvas>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 d-flex justify-content-center align-items-baseline">
                <form class="border border-muted rounded m-2 p-2" id="frm-time" style="width:100%;max-width:fit-content">
                    <div class="text-center">
                        <label for="">Time</label>
                        <hr class="text-dark" style="flex-grow: 1; margin-left: 10px;">
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="radio" name="checkTime" id="checkPer" checked>
                        <label class="  text-danger fw-bold" for="Period">PERIOD</label>
                        <div class="d-flex col align-items-center">
                            <label class="me-1" for="">*Start</label>
                            <input class="form-control" type="date" id="period" name="period">
                        </div>
                        <div class="d-flex col align-items-center">
                            <label class="me-1" for="">*End</label>
                            <input class="form-control" type="date" id="periodEnd" name="periodEnd">
                        </div>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="radio" name="checkTime" id="checkDay" >
                        <div class="d-flex col">
                            <label class="me-1  text-danger fw-bold" for="">DAY</label>
                            <input class="form-control" type="date" id="oneday" name="checkDay">
                        </div>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="radio" name="checkTime" id="checkMonth" >
                        <div class="d-flex col">
                            <label class="me-1  text-danger fw-bold" for="">MONTH</label>
                            <input class="form-control" type="month" id="onemonth" name="checkMonth">
                        </div>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="radio" name="checkTime" id="checkYear" >
                        <div class="d-flex col">
                            <label class="me-1  text-danger fw-bold" for="">YEAR</label>
                            <input class="form-control" type="number" id="oneyear" name="checkYear" min="1900" max="2099" step="1">
                        </div>
                    </div>
                </form>
                
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4  d-flex justify-content-center align-items-baseline">
            <form class="border border-muted rounded m-2 p-2" id="frm-class" style="width:100%;max-width:fit-content;">
                    <div class="text-center">
                        <label for="">Class</label>
                        <hr class="text-dark" style="flex-grow: 1; margin-left: 10px;">
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="radio" name="checkClass" id="checkMoreCat" checked>
                        <input class="form-control dropdown-toggle" type="text" id="categoryInput" data-bs-toggle="dropdown" placeholder="Choose category" readonly>
                        <ul id="categoryCheckboxes" class="dropdown-menu ul-drop" aria-labelledby="categoryInput">
                            <!-- Các checkbox sẽ được thêm vào đây -->
                        </ul>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="radio" name="checkClass" id="checkMoreProduct">
                        <input class="form-control dropdown-toggle" type="text" id="productInput" data-bs-toggle="dropdown" placeholder="Choose product" readonly>
                        <ul id="productCheckboxes" class="dropdown-menu ul-drop-product overflow-auto" style="height: 300px;" aria-labelledby="productInput">
                            <!-- Các checkbox sẽ được thêm vào đây -->
                        </ul>
                    </div>
                    <button class="btn btn-primary m-2" id="list-chart">List chart</button>
                </form>   
                <button class="btn btn-primary m-2" id="changeType">Change type</button>
            </div>
        </div>
    </div>
@section('scripts')

<script>
    //chỉnh input năm nếu nhập số ngoài khoảng phép
    document.getElementById('oneyear').addEventListener('change', (event) => {
    let value = event.target.value;
    if (value < 1900) {
        event.target.value = 1900;
    } else if (value > 2099) {
        event.target.value = 2099;
    }
    });

    var myChart;
    window.addEventListener('load', (event) => {
        var dataArray=['1','2']
    var colorArray = dataArray.map(function() {
        return getRandomColor();
    });
    var ctx = document.getElementById('myChart').getContext('2d');
    myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Ex1','Ex2'],
            datasets: [{
                label: 'My Dataset',
                data: dataArray,
                backgroundColor: colorArray}]
        },options: {
                title: {
                display: true,
                text: 'Total sales and revenue'
                }
            }
    });
        document.getElementById("period").max = today;
        document.getElementById("periodEnd").max = today;
        document.getElementById("oneday").max = today;
        document.getElementById("onemonth").max = year + '-' + month;
        document.getElementById("oneyear").max = year;
        $.ajax({
        url: '/invoice/getCategory', // Thay đổi thành endpoint của bạn
        type: 'POST',
        data: {
            _token: '{{csrf_token()}}' // Thêm CSRF token vào đây
        },
        success: function(response) {
            if(response.success) {
                var html = '';
                $.each(response.cat, function(i, v) {
                    html += `<li class="ms-2"><input type="checkbox" value="${v.CategoryId}" data-name="${v.CategoryName}">${v.CategoryName}</li>`;
                });
                $('.ul-drop').html(html);
                $('#categoryCheckboxes li input[type="checkbox"]').change(updateInput); // Thêm sự kiện change vào mỗi checkbox
            } else {
                console.log(response.msg);
                alert(response.msg);
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
    $.ajax({
        url: '/invoice/getProductul', // Thay đổi thành endpoint của bạn
        type: 'POST',
        data: {
            _token: '{{csrf_token()}}' // Thêm CSRF token vào đây
        },
        success: function(response) {
            if(response.success) {
                var html = '';
                $.each(response.pro, function(i, v) {
                    html += `<li class="ms-2"><input type="checkbox" value="${v.id}" data-name="${v.name}">${v.name}</li>`;
                });
                $('.ul-drop-product').html(html);
                $('#productCheckboxes li input[type="checkbox"]').change(updateInputProduct); // Thêm sự kiện change vào mỗi checkbox
            } else {
                console.log(response.msg);
                alert(response.msg);
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
});
document.getElementById('changeType').addEventListener('click', function() {
    myChart.config.type = myChart.config.type === 'pie' ? 'doughnut' : 'pie';
    myChart.update();
});
$(document).ready(function() {
    
    $('#list-chart').on('click', function(e) {
        e.preventDefault(); 
        var checkedInput = document.querySelector('#frm-time input[type="radio"]:checked');
        var checkedInputId = checkedInput.id;
        var checkedInputClass = document.querySelector('#frm-class input[type="radio"]:checked');
        var checkedInputClassId = checkedInputClass.id;
        var arrayClass=[];
        //kiểm tra phân loại
        if(checkedInputClassId==="checkMoreCat"){
            var inputClass=document.getElementById("categoryInput").value;
            var curl='/invoice/getChartDetail';
        }else{
            var inputClass=document.getElementById("productInput").value;
            var curl='/invoice/getChartDetailProduct';
            console.log(curl);
        }
        //lấy giá trị trong phân loại
        
        var getClass=[];
        if(inputClass=='')
            {
                alert('Please select class!');
                return;
            }else{
            getClass = inputClass.split(", ");
            arrayClass = arrayClass.concat(getClass);
            }
            //kiểm tra và lấy giá trị ngày
        if(checkedInputId==="checkPer")
            {
                var dayStart = document.getElementById("period").value;
                var dayEnd = document.getElementById("periodEnd").value;
                if(dayStart =='' || dayEnd == '')
                {
                    alert('Please check start day and end day!');
                    return;
                }else{
                    var arrayTime=[dayStart,dayEnd];
                    console.log(arrayTime);
                }
            }
            else{
                var oneTime = document.getElementsByName(checkedInputId)[0].value;
                console.log(oneTime);
                if(oneTime ==='')
                {
                    alert('Please check and choose a day!');
                    return;
                }else{
                    var arrayTime=[];
                    arrayTime=oneTime.split('-');
                    // console.log(arrayTime);
                    console.log(arrayClass);
                    // return;
                }
            }
            $.ajax({
            url: curl,
            type: 'POST',
            data: {
                checkedInputId: checkedInputId,
                arrayTime:arrayTime,
                arrayClass:arrayClass,
                _token: '{{csrf_token()}}'
            }, 
            success: function(response)
            {
                if(response.success)
                    {
                        console.log(Chart);
                    // Xử lý dữ liệu từ response.Chart
                    document.getElementById('myexChart').innerHTML='<canvas id="myChart" style="width:100%;max-width:500px"></canvas>';
                    var labels = [];
                    var data = [];
                    var data2 = [];
                    var totalSL=0;
                    var totalDT=0;
                    for (var i = 0; i < response.Chart.length; i++) {
                        for (var j = 0; j < response.Chart[i].length; j++) {
                            labels.push(response.Chart[i][j].Name);
                            data.push(response.Chart[i][j].TongSL);
                            data2.push(response.Chart[i][j].TongDT);
                            totalSL+=parseInt(response.Chart[i][j].TongSL);
                            totalDT+=parseInt(response.Chart[i][j].TongDT);
                        }
                    }
                    var colorArray1 = data.map(function() {
                        return getRandomColor();
                    });
                    var ctx1 = document.getElementById('myChart').getContext('2d');
                    myChart = new Chart(ctx1, {
                        type: 'pie',
                        data: {
                            labels: labels,  // Sử dụng labels từ response.Chart
                            datasets: [{
                                label: 'Total Sales',
                                data: data,  // Sử dụng data từ response.Chart
                                backgroundColor: colorArray1},
                                {
                                label: 'Total Revenue',
                                data: data2,  // Sử dụng data2 từ response.Chart
                                backgroundColor: colorArray1}]
                        },options: {
                            plugins: {
                                title: {
                                    display: true,
                                    text: ['Total sales and revenue at '+response.Chart[0][0].Ngay , 'with Sales: '+ totalSL +' and Revenue: '+ totalDT+'VND.']
                                }
                            }
                        }
                    });
                }
                else
                    {
                        console.log(response.error);
                    }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                console.log(checkedInputId);
                console.log(arrayClass);
                console.log(arrayTime);
                console.log(textStatus, errorThrown);
            }
        });
    });
});
    $('#categoryInput').click(function() {
        $('#categoryCheckboxes').toggle();
    });
    $('#productInput').click(function() {
        $('#productCheckboxes').toggle();
    });
    function updateInput() {
        var selected = [];
        $('#categoryCheckboxes li input[type="checkbox"]:checked').each(function() {
            selected.push($(this).attr('data-name'));
        });
        $('#categoryInput').val(selected.join(', '));
    }
    function updateInputProduct() {
        var selected = [];
        $('#productCheckboxes li input[type="checkbox"]:checked').each(function() {
            selected.push($(this).attr('data-name'));
        });
        $('#productInput').val(selected.join(', '));
    }
    var today = new Date().toISOString().split('T')[0];
    var tod = new Date();
    var month = tod.getMonth() + 1; // getMonth() trả về giá trị từ 0 (tháng 1) đến 11 (tháng 12), vì vậy chúng ta cần cộng thêm 1
    var year = tod.getFullYear();
document.getElementById("period").addEventListener("change", function() {
    var date = new Date(this.value);
    date.setDate(date.getDate() + 1);
    var nextDay = date.toISOString().split('T')[0];
    document.getElementById("periodEnd").min = nextDay;
    document.getElementById("period").max = today;
});

document.getElementById("periodEnd").addEventListener("change", function() {
    var date = new Date(this.value);
    date.setDate(date.getDate() - 1);
    var nextDay = date.toISOString().split('T')[0];
    document.getElementById("period").max = nextDay;
    document.getElementById("periodEnd").max = today;
});


    function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    

</script>
@endsection
@endsection
