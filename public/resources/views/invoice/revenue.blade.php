@extends('shared.layoutadmin')
@section('body')
@section('title','Revenue')
@csrf    
    <div class="container-fluid py-4">
      <div class="row mt-2">
        <div class="col-lg-6 col-md-6 mt-4 mb-5">
          <div class="card z-index-2  ">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
              <div class="bg-secondary shadow-success border-radius-lg py-3 pe-1">
                <div class="chart" id="chart-revenue">
                  <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
                </div>
              </div>
            </div>
            <div class="card-body">
              <h6 class="mb-0 ">Revenue</h6>
              <p class="text-sm ">Product revenue chart based on filters</p>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 mt-4 mb-5">
          <div class="card z-index-2  ">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
              <div class="bg-light shadow-success border-radius-lg py-3 pe-1">
                <div class="chart" id="chart-amount">
                  <canvas id="chart-bars" class="chart-canvas material-icons-setting-chart" height="170"></canvas>
                </div>
              </div>
            </div>
            <div class="card-body">
              <h6 class="mb-0 ">Amount</h6>
              <p class="text-sm ">Chart of sales volume based on filters</p>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 mt-4 mb-4">
          <div class="card z-index-2 ">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
              <div class="bg-white shadow-primary border-radius-lg py-3 pe-1">
                <div class="container d-flex justify-content-center align-items-baseline">
                  <form class="m-2 p-2" id="frm-time" style="width:100%; height: 100%;">
                      <div class="form-check mt-2">
                          <input class="form-check-input" type="radio" name="checkTime" id="checkPer" checked>
                          <label class="text-danger fw-bold" for="checkPer">PERIOD</label>
                          <div class="d-flex align-items-center">
                              <span class="input-group-text pe-1 ps-1 bg-gradient-danger text-white" id="startday">Start</span>
                              <div class="input-group input-group-outline">
                              <input class="form-control" type="date" id="period" name="period" aria-describedby="startday"></div>
                          </div>
                          <div class="d-flex align-items-center">
                              <span class="input-group-text pe-1 ps-1 bg-gradient-danger text-white" id="startday">End</span>
                              <div class="input-group input-group-outline">
                              <input class="form-control" type="date" id="periodEnd" name="periodEnd"></div>
                          </div>
                      </div>
                      <div class="form-check mt-2">
                          <input class="form-check-input" type="radio" name="checkTime" id="checkDay">
                          <label class="text-danger fw-bold" for="checkDay">DAY</label>
                          <div class="input-group input-group-outline">
                          <input class="form-control" type="date" id="oneday" name="checkDay">
                          </div>
                      </div>
                      <div class="form-check mt-2">
                          <input class="form-check-input" type="radio" name="checkTime" id="checkMonth">
                          <label class="text-danger fw-bold" for="checkMonth">MONTH</label>
                          <div class="input-group input-group-outline">
                          <input class="form-control" type="month" id="onemonth" name="checkMonth">
                          </div>
                      </div>
                      <div class="form-check mt-2">
                          <input class="form-check-input" type="radio" name="checkTime" id="checkYear">
                          <label class="text-danger fw-bold" for="checkYear">YEAR</label>
                          <div class="input-group input-group-outline">
                          <input class="form-control" type="number" id="oneyear" name="checkYear" min="1900" max="2099" step="1">
                          </div>
                      </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="card-body">
              <h6 class="mb-0 ">Time</h6>
              <p class="text-sm ">Choose when to filter data</p>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 mt-4 mb-4">
          <div class="card z-index-2  ">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
              <div class="bg-white shadow-success border-radius-lg py-3 pe-1">
                <div class="container d-flex justify-content-center align-items-baseline">
                  <form class="m-2 p-2" id="frm-class" style="width:100%;height: 100%;">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="radio" name="checkClass" id="checkMoreCat" checked>
                        <label class="text-danger fw-bold">CATEGORY</label>
                        <div class="input-group input-group-outline">
                        <input class="form-control dropdown-toggle" type="text" id="categoryInput" data-bs-toggle="dropdown" placeholder="Choose category" readonly>
                        </div>
                        <ul id="categoryCheckboxes" class="dropdown-menu ul-drop border" aria-labelledby="categoryInput">
                            <!-- Các checkbox sẽ được thêm vào đây -->
                        </ul>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="radio" name="checkClass" id="checkMoreProduct">
                        <label class="text-danger fw-bold">PRODUCTS</label>
                        <div class="input-group input-group-outline">
                        <input class="form-control dropdown-toggle" type="text" id="productInput" data-bs-toggle="dropdown" placeholder="Choose product" readonly></div>
                        <ul id="productCheckboxes" class="dropdown-menu ul-drop-product overflow-auto border" style="height: 300px;" aria-labelledby="productInput">
                            <!-- Các checkbox sẽ được thêm vào đây -->
                        </ul>
                    </div>
                </form>
                </div>
              </div>
            </div>
            <div class="card-body">
              <h6 class="mb-0 ">Category & Products</h6>
              <p class="text-sm ">Choose category or products to filter data</p>
              <button class="btn btn-primary m-2" id="list-chart">List chart</button>
            </div>
          </div>
        </div>
        <div class="col-lg-12 col-md-6 mt-4 mb-4">
          <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">List chart table</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table id="chart-table-list" class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th colspan="2" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                      <th colspan="2" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Amount</th>
                      <th colspan="2" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Revenue</th>
                    </tr>
                  </thead>
                  <tbody id="body-table">
                    
                    <tr>
                      <td colspan="2">
                        <p class="text-xs font-weight-bold mb-0">Programator</p>
                      </td>
                      <td colspan="2">
                        <p class="text-xs font-weight-bold mb-0">Programator</p>
                      </td>
                      <td colspan="2">
                        <p class="text-xs font-weight-bold mb-0">100000$</p>
                      </td>
                    </tr>
                    
                  </tbody>
                  <tr id="footer-table">
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Time</p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">100000$</p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Amount</p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">100000$</p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Revenue</p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">100000$</p>
                      </td>
                    </tr>
                </table>
                <button class="btn btn-primary m-2"  onclick="exportTableToExcel()">Export To Excel</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>      
</div>

@section('scripts')
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
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

    window.addEventListener('load', (event) => {
      var dataArray=['1','2'];
        var dataArrayPrice=['10000','20000'];
        var label=['Ex1','Ex2'];
        var colorArray = dataArray.map(function() {
        return getRandomColor();
    });
        var ctx = document.getElementById("chart-bars").getContext("2d");
        var ctx2 = document.getElementById("chart-line").getContext("2d");
        getChart(ctx, ctx2, dataArray, dataArrayPrice, label, colorArray,'Amount', 'Price');
        document.getElementById("period").max = today;
        document.getElementById("periodEnd").max = today;
        document.getElementById("oneday").max = today;
        document.getElementById("onemonth").max = year + '-' + month;
        document.getElementById("oneyear").max = year;
        $.ajax({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
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
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
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
                headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
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
                    // Xử lý dữ liệu từ response.Chart

                    document.getElementById('chart-amount').innerHTML='<canvas id="chart-bars" class="chart-canvas material-icons-setting-chart" height="170"></canvas>';
                    document.getElementById('chart-revenue').innerHTML='<canvas id="chart-line" class="chart-canvas" height="170"></canvas>';
                    var ctx1 = document.getElementById("chart-bars").getContext("2d");
                    var ctx3 = document.getElementById("chart-line").getContext("2d");
                    var labels = [];
                    var data = [];
                    var data2 = [];
                    var totalSL=0;
                    var totalDT=0;
                    document.getElementById('body-table').innerHTML=``;
                    for (var i = 0; i < response.Chart.length; i++) {
                        for (var j = 0; j < response.Chart[i].length; j++) {
                            labels.push(response.Chart[i][j].Name);
                            data.push(response.Chart[i][j].TongSL);
                            data2.push(response.Chart[i][j].TongDT);
                            totalSL+=parseInt(response.Chart[i][j].TongSL);
                            totalDT+=parseInt(response.Chart[i][j].TongDT);
                            document.getElementById('body-table').innerHTML+=`<tr>
                      <td colspan="2">
                        <p class="text-xs font-weight-bold mb-0">`+response.Chart[i][j].Name+`</p>
                      </td>
                      <td colspan="2">
                        <p class="text-xs font-weight-bold mb-0">`+response.Chart[i][j].TongSL+`</p>
                      </td>
                      <td colspan="2">
                        <p class="text-xs font-weight-bold mb-0">`+response.Chart[i][j].TongDT+`</p>
                      </td>
                    </tr>`;
                        }
                    }
                    switch(checkedInputId){
                      case 'checkPer': document.getElementById('footer-table').innerHTML=`<td>
                        <p class="text-xs font-weight-bold mb-0">Time</p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">From `+arrayTime[0]+` to `+arrayTime[1]+`</p>
                      </td>`;break;
                      case'checkDay':case'checkMonth':case'checkYear':document.getElementById('footer-table').innerHTML=`<td>
                        <p class="text-xs font-weight-bold mb-0">Time</p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">`+document.getElementsByName(checkedInputId)[0].value+`</p>
                      </td>`;break;
                      default:break;
                    }
                      document.getElementById('footer-table').innerHTML+=`
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Total amount</p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">`+totalSL+`</p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Total revenue</p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">`+totalDT+`</p>
                      </td>`;
                    var colorArray1 = data.map(function() {
                        return getRandomColor();
                    });
                    getChart(ctx1, ctx3, data, data2, labels, colorArray1,'Amount', 'Price');
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

 
function getChart($ctx, $ctx2, $dataArray, $dataArrayPrice, $labelArray, $colorArray, $labelt,$labelArrayPrice){
    //chat pie
    var myChart= new Chart($ctx, {
      type: "pie",
      data: {
        labels: $labelArray,
        datasets: [{
          label: $labelt,
          tension: 0.4,
          borderWidth: 2, // Độ dày của viền
          borderColor: 'rgba(0, 0, 0, 0.5)', // Màu của viền
          borderRadius: 4,
          borderSkipped: false,
          backgroundColor: $colorArray,
          data: $dataArray,
          maxBarThickness: 6
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        }
    });

    //chart line

    var myChart2= new Chart($ctx2, {
      type: "line",
      data: {
        labels: $labelArray,
        datasets: [{
          label: $labelArrayPrice,
          tension: 0,
          borderWidth: 0,
          pointRadius: 5,
          pointBackgroundColor: "rgba(255, 255, 255, .8)",
          pointBorderColor: "transparent",
          borderColor: "rgba(255, 255, 255, .8)",
          borderColor: "rgba(255, 255, 255, .8)",
          borderWidth: 4,
          backgroundColor: "transparent",
          fill: true,
          data: $dataArrayPrice,
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5],
              color: 'rgba(255, 255, 255, .2)'
            },
            ticks: {
              display: true,
              color: '#f8f9fa',
              padding: 10,
              font: {
                size: 14,
                weight: 300,
                family: "Roboto",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#f8f9fa',
              padding: 10,
              font: {
                size: 14,
                weight: 300,
                family: "Roboto",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
}
    
function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    
    
        function exportTableToExcel() {
    var table = document.getElementById('chart-table-list');
    var worksheet = XLSX.utils.table_to_book(table);
    var wbout = XLSX.write(worksheet, {bookType:'xlsx', bookSST:true, type: 'binary'});
    
    var blob = new Blob([s2ab(wbout)], {type:"application/octet-stream"});
    
    var link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.download = 'data.xlsx';
    
    link.click();
}

function s2ab(s) {
    var buf = new ArrayBuffer(s.length);
    var view = new Uint8Array(buf);
    for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
    return buf;
}
</script>
@endsection
@endsection
