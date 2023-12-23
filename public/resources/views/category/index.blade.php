@extends('shared.layoutadmin')
@section('title','Category')
@section('body')
<div class="container-fluid py-4">
      <div class="row">
<div class="col-lg-12 col-md-6 mb-4">
          <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 d-flex justify-content-between align-items-center">
                <h6 class="text-white text-capitalize ps-3">Category</h6>
                <button type="button" class="btn btn-warning hover-overlay shadow me-3" data-bs-toggle="modal" data-bs-target="#exampleModal" data-toggle="tooltip" title="Create Category">
                    <i class="bi bi-bookmark-plus-fill fa-lg"></i>
                </button>  
            </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table id="chart-table-list" class="table table-hover align-items-center mb-0" style="table-layout: fixed;">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Category name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Image</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Command</th>
                    </tr>
                  </thead>
                  <tbody id="body-table">
                    @foreach($arr as $v)
                    <tr>
                        <td class="td_input" id="{{$v['CategoryId']}}">{{$v['CategoryName']}}</td>
                        <td class="des text-wrap"  id="{{$v['CategoryId']}}">{!! htmlspecialchars_decode($v['Description']) !!}</td>
                        <td>
                            <img class="im_g img-fluid border-radius-lg" id="{{$v['CategoryId']}}" src="/images/product/{{$v['ImageUrl']}}" alt="" width="100">
                        </td>
                        <td>
                            <a class="btn btn-warning btn_trash hover-overlay" id="{{$v['CategoryId']}}" name="{{$v['CategoryName']}}" data-toggle="tooltip" title="Delete"><i class="bi bi-trash-fill fa-lg"></i></a>
                            <a class="btn btn-warning btn_edit hover-overlay" id="{{$v['CategoryId']}}" name="{{$v['CategoryName']}}" data-toggle="tooltip" title="Edit"><i class="bi bi-pencil-square fa-lg"></i></a>
                        </td>
                        </tr>
                    @endforeach
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
      </div></div>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="liveToast" class="toast hide" Category="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <img src="/images/page/tenor.gif" class="rounded-circle me-2 img-fluid" style="width: 4.5vh; height: 4.5vh;">
      <strong class="me-auto text-danger">Thông báo</strong>
      <small></small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body text-dark">
    </div>
  </div>
</div>
@section('scripts')
<script>
  function htmlDecode(input){
  var doc = new DOMParser().parseFromString(input, "text/html");
  return doc.documentElement.textContent;
}
var deleteContent='<label class="text-dark ">Category Name:</label> @csrf <span class="text-dark" name="CategoryName"></span>';
createModal('modalDelete', 'frm_delete', '/category/cdelete', 'Are you sure delete?', deleteContent);
var createContent='@csrf <label class="text-dark">Category Name</label> <input class="text-dark rounded" type="text" name="CategoryName" placeholder="enter name..."> <br> <label class="text-dark">Description</label> <textarea name="Description"  cols="30" rows="10"></textarea> <br> <label class="text-dark">Image</label> <input id="file" type="file" name="ImageUrl">';
createModal('exampleModal', 'frm_add', '/category/add', 'Create Category', createContent);
var editContent='@csrf <label class="text-dark">Category Name</label> <input class="text-dark rounded" type="text" name="CategoryName">  <br> <label class="text-dark">Description</label> <textarea name="Description"  cols="30" rows="10"></textarea> <br> <label class="text-dark">Image</label> <input id="file" type="file" name="ImageUrl"> <img name="imgLast" src="" alt="" width="100">';
createModal('modalEdit', 'frm_edit', '/category/edit', 'Edit Category', editContent);
function showToast(active,name) {
  $('#liveToast div.toast-body').text(active+' thành công '+name+'!');
  $('#liveToast').toast('show');
  startTime = new Date();
  updateTime();
  setInterval(updateTime, 1000);
};
var description;
function click(btn,idm,item,kt){
    $('body').on('click', btn, function() {
    var name = $(this).attr('name');
    var id = $(this).attr('id');
    description = $('.des[id="'+id+'"]').html(); //lấy dữ liệu từ thẻ td có class des và id bằng id
    var img = $('.im_g[id="'+id+'"]').attr('src'); //lấy đường dẫn từ thẻ img có class im_g và id bằng id
    if(kt=='text'){
      $('#'+idm+' '+item+'[name="CategoryName"]').text(name);
    }
    else{
      $('#'+idm+' '+item+'[name="CategoryName"]').val(name);
      $('#'+idm+' textarea[name="Description"]').data("kendoEditor").value(description);
      $('#'+idm+' input[name="ImageUrl"]').val('');
      $('#'+idm+' img[name="imgLast"]').attr('src',img);
    }
    $('#'+idm+' div form').data('id', id);
    $('#'+idm).modal('show');
  });
}
$('#modalEdit input[name="ImageUrl"]').on('change', function(e) {
    var file = e.target.files[0];
    var reader = new FileReader();

    reader.onloadend = function() {
        document.querySelector('#modalEdit img[name="imgLast"]').src = reader.result;
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        document.querySelector('#modalEdit img[name="imgLast"]').src = "";
    }
});
click('.btn_trash','modalDelete','span','text');
click('.btn_edit','modalEdit','input','val');
var edit;
$('form[name="frm_edit"]').on('submit', function(e) {
  e.preventDefault();
  var id = $(this).data('id');
  var formData = new FormData(this);
  for (var pair of formData.entries()) {
    console.log(pair[0]+ ', ' + pair[1]); 
}
  $.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/category/edit/' + id,
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function(data) {
      edit=$('td.td_input[id="' + id + '"]').text();
      if(data.success) {
        var CategoryName = data.CategoryName;
        var Description = htmlDecode(data.Description);
        var img = data.ImageUrl;
        var row = $('a.btn_edit[id="' + id + '"]').closest('tr');
        row.find('.td_input[id="' + id + '"]').text(CategoryName);
        row.find('.des[id="' + id + '"]').html(Description);
        row.find('.im_g[id="' + id + '"]').attr('src','/images/product/'+img);
        row.find('.btn_trash[id="' + id + '"], .btn_edit[id="' + id + '"]').attr('name', CategoryName);
        $('#modalEdit').modal('hide');
        showToast('Đã chỉnh sửa '+edit,'sang '+CategoryName);
      } else {
        $('#modalEdit').modal('hide');
        showToast('Không thể sửa ','Category '+edit);
        console.log(data);
      }
    },error: function(data) {
      $('#modalEdit').modal('hide');
      showToast('Không thể chỉnh sửa ','Category do có lỗi');
      console.log(data);
    }
  });
});
var trash;
$('form[name="frm_delete"]').on('submit', function(e) {
  e.preventDefault();
  var id = $(this).data('id');
  console.log(id);
  $.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/category/cdelete/' + id,
    type: 'POST',
    data: { _token: $('input[name="_token"]').val() },
    success: function(data) {
      console.log(data);
      trash=$('td.td_input[id="' + id + '"]').text();
      if(data.success == true) {
        $('a.btn_trash[id="' + id + '"]').closest('tr').remove();
        $('#modalDelete').modal('hide');
        showToast('Đã xóa ','Category '+trash);
      } else {
        $('#modalDelete').modal('hide');
        showToast('Không thể xóa ','Category');
      }
    },error: function(data) {
      console.log(data);
      $('#modalDelete').modal('hide');
      showToast('Không thể xóa ','Category do có lỗi');
    }
  });
});
$('form[name="frm_add"]').on('submit', function(e) {
  e.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/category/add',
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function(data) {
      if(data.success) {
        var description = htmlDecode(data.Description);
    var newRow = `<tr>
    <td class="td_input" id="${data.CategoryId}">${data.CategoryName}</td>
    <td class="des text-wrap" id="${data.CategoryId}">${description}</td>
    <td>
      <img class="im_g" src="/images/product/${data.ImageUrl}" alt="" width="100">
    </td>
    <td>
      <a class="btn btn-warning btn_trash" id="${data.CategoryId}" name="${data.CategoryName}"><i class="bi bi-trash-fill"></i></a>
      <a class="btn btn-warning btn_edit" id="${data.CategoryId}" name="${data.CategoryName}"><i class="bi bi-pencil-square"></i></a>
    </td>
    </tr>`;

        $('.table tbody').append(newRow);
        $('#exampleModal').modal('hide');
        showToast('Đã thêm ','Category '+data.CategoryName);
        $('input[name="CategoryName"]').val('');
      } else {
        $('#exampleModal').modal('hide');
        showToast('Không thể thêm ','Category đã tồn tại');
      }
    },
    error: function(data) {
      $('#exampleModal').modal('hide');
      showToast('Không thể thêm ','Category do có lỗi');
    }
  });
});


var startTime;
function updateTime() {
  var now = new Date();
  seconds = Math.round((now - startTime) / 1000);
  var timeString = 'just now';
  if (seconds > 1) {
    timeString = seconds + ' seconds later';
  }
  document.querySelector('.toast-header small').textContent = timeString;
}
function createModal(modalId, formName, action, title, bodyContent) {
    var modal = document.createElement("div");
    modal.setAttribute("class", "modal fade");
    modal.setAttribute("id", modalId);
    modal.setAttribute("tabindex", "-1");
    modal.setAttribute("aria-labelledby", "exampleModalLabel");
    modal.setAttribute("aria-hidden", "true");
    var modalDialog = document.createElement("div");
    modalDialog.setAttribute("class", "modal-dialog");
    var form = document.createElement("form");
    form.setAttribute("name", formName);
    form.setAttribute("action", action);
    form.setAttribute("method", "post");
    form.setAttribute("enctype", "multipart/form-data");
    form.setAttribute("class", "modal-content");
    var modalHeader = document.createElement("div");
    modalHeader.setAttribute("class", "modal-header");
    var h5 = document.createElement("h5");
    h5.setAttribute("class", "modal-title fw-bold text-dark");
    h5.setAttribute("style", "color: #f6c23e !important;");
    h5.setAttribute("id", "exampleModalLabel");
    h5.innerHTML = title;
    var modalBody = document.createElement("div");
    modalBody.setAttribute("class", "modal-body");
    modalBody.innerHTML = bodyContent;
    var modalFooter = document.createElement("div");
    modalFooter.setAttribute("class", "modal-footer");
    var button1 = document.createElement("button");
    button1.setAttribute("type", "button");
    button1.setAttribute("class", "btn btn-danger");
    button1.setAttribute("data-bs-dismiss", "modal");
    button1.value = "no";
    var i1 = document.createElement("i");
    i1.setAttribute("class", "fas fa-times fa-lg");
    var button2 = document.createElement("button");
    button2.setAttribute("class", "btn btn-warning");
    button2.value = "yes";
    var i2 = document.createElement("i");
    i2.setAttribute("class", "fas fa-cloud-upload-alt fa-lg");
    button1.appendChild(i1);
    button2.appendChild(i2);
    modalFooter.appendChild(button1);
    modalFooter.appendChild(button2);
    modalHeader.appendChild(h5);
    form.appendChild(modalHeader);
    form.appendChild(modalBody);
    form.appendChild(modalFooter);
    modalDialog.appendChild(form);
    modal.appendChild(modalDialog);
    document.body.appendChild(modal);
}
$('textarea[name="Description"]').kendoEditor();
</script>
@endsection
@endsection




