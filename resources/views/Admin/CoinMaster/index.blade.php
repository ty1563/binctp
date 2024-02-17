@extends('Admin.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-sm-12">
            <div class="card">
                <h3>
                    Chạy Link CoinMaster
                </h3>
                <form v-on:submit.prevent="run()" id="formdata">
                    <div class="card-body">
                        <div class="mb-2">
                            <label>Chọn Loại</label>
                            <select name="type" class="form-control">
                                <option value="0" selected>Link Thường</option>
                                <option value="1">Link Extra</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Nhập Link Mời</label>
                            <input type="text" class="form-control" name="link" placeholder="VD : https://GetCoinMaster.com/~xxxxxxxx?s=m">
                        </div>
                        <div class="mb-2">
                            <label>Số Lượng</label>
                            <input type="text" class="form-control" name="number" placeholder="Tối Đa 3 Lần Mỗi 1 Link">
                        </div>
                        <div class="mt-2 text-end">
                            <h5>Thành Tiền : <span class="text-primary">16.000</span></h5>
                        </div>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-success">Lên Đơn</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-sm-12">
            <table class="table table-bordered">
                <thead>
                    <h5>Thông Tin Link Đang Chạy</h5>
                </thead>
                <tbody>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Loại</th>
                        <th class="text-center">Link Mời</th>
                        <th class="text-center">Số Lượng</th>
                        <th class="text-center">Trạng Thái</th>
                        <th class="text-center">Chi Tiết</th>
                    </tr>
                    <tr>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
<script>
    new Vue({
        el      :   '#app',
        data    :   {

        },
        created()   {

        },
        methods :   {
            run(){
                var paramObj = {};
                $.each($('#formdata').serializeArray(), function(_, kv) {
                    if (paramObj.hasOwnProperty(kv.name)) {
                        paramObj[kv.name] = $.makeArray(paramObj[kv.name]);
                        paramObj[kv.name].push(kv.value);
                    } else {
                        paramObj[kv.name] = kv.value;
                    }
                });
                axios
                    .post('/admin/cmspin/add', paramObj)
                    .then((res) => {
                     if(res.data.status){
                        toastr.success(res.data.message);
                    } else {
                        toastr.error(res.data.message);
                    }
                    })
                    .catch((res) => {
                        $.each(res.response.data.errors, function(k, v) {
                            toastr.error(v[0]);
                        });
                    });
            },
        },
    });
</script>
@endsection
