@extends('Admin.master')
@section('noi_dung')
    <div class="row" id="app">
        <form id="formdata" v-on:submit.prevent="add()">
            <div>
                <div>
                    <label class="form-label">Câu Hỏi</label>
                    <input required class="form-control" type="text" name="cau_hoi" v-model ="cau_hoi" placeholder="Điền Câu Hỏi">
                    <label class="form-label">Trả Lời</label>
                    <textarea required name="tra_loi" v-model="tra_loi" cols="20" rows="5" class="form-control text-darkmod" placeholder="Điền Câu Trả Lời"></textarea>
                    <label class="form-label">Xếp Hạng</label>
                    <select required name="xep_hang" v-model="xep_hang" class="form-control text-darkmod">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
                <div class="text-end mt-2">
                    <button type="submit" class="btn btn-success">Thêm Mới</button>
                </div>
            </div>
        </form>
        <div class="mt-3">
            <table class="table">
                <tr>
                    <td class="text-center bold-text">Xếp Hạng</td>
                    <td class="text-center bold-text">Câu Hỏi</td>
                    <td class="text-center bold-text">Trả Lời</td>
                    <td class="text-center bold-text">Action</td>
                </tr>
                <tr v-if="view<767" v-for="(v,k) in listCauHoi" v-on:click="edit = v" data-bs-toggle="modal" data-bs-target="#infoo">
                    <td class="text-center bold-text">@{{ v.xep_hang }}</td>
                    <td class="text-center">@{{ v.cau_hoi }}</td>
                    <td class="text-center">
                        <textarea class="text-darkmod" cols="30" rows="5">@{{ v.tra_loi }}</textarea>
                    </td>

                    <td class="text-center">
                        <button v-on:click="edit = v" type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#infoo">
                            Cập Nhật
                        </button>
                        <button v-on:click="xoa(v.id)" class="btn btn-danger">Xóa Bỏ</button>
                    </td>
                </tr>
                <tr v-if="view>767" v-for="(v,k) in listCauHoi">
                    <td class="text-center bold-text">@{{ v.xep_hang }}</td>
                    <td class="text-center">@{{ v.cau_hoi }}</td>
                    <td class="text-center">
                        <textarea class="text-darkmod" cols="30" rows="5">@{{ v.tra_loi }}</textarea>
                    </td>

                    <td class="text-center">
                        <button v-on:click="edit = v" type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#infoo">
                            Cập Nhật
                        </button>
                        <button v-on:click="xoa(v.id)" class="btn btn-danger">Xóa Bỏ</button>
                    </td>
                </tr>
                <div class="modal fade" id="infoo" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-darkmod" id="exampleModalLabel">Cập Nhật Câu Hỏi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label class="text-darkmod form-label">Câu Hỏi</label>
                                <input required class="text-darkmod form-control" type="text" v-model="edit.cau_hoi" placeholder="Điền Câu Hỏi">
                                <label class="text-darkmod form-label">Trả Lời</label>
                                <textarea required v-model="edit.tra_loi" cols="20" rows="5" class="text-darkmod form-control"></textarea>
                                <label class="text-darkmod form-label">Xếp Hạng</label>
                                <select required v-model="edit.xep_hang" class="form-control text-darkmod">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" data-bs-dismiss="modal"  v-on:click="xoa(edit.id)" class="btn btn-danger">Xóa</button>
                                <button type="submit" data-bs-dismiss="modal" v-on:click="updateInfo()"
                                    class="btn btn-primary">Lưu</button>
                            </div>
                        </div>
                    </div>
                </div>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                cau_hoi: null,
                tra_loi: null,
                listCauHoi: [],
                xep_hang: null,
                view: window.innerWidth,
                edit : {},
            },
            created() {
                this.load();
            },
            methods: {
                ori() {
                    this.cau_hoi = null;
                    this.tra_loi = null;
                },
                add() {
                    var paramObj = {
                        'cau_hoi': this.cau_hoi,
                        'tra_loi': this.tra_loi,
                        'xep_hang': this.xep_hang,
                    };
                    axios
                        .post('/admin/question/add', paramObj)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.load();
                                ori();
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
                load() {
                    axios
                        .post('/admin/question/data', 1)
                        .then((res) => {
                            if (res.data.status) {
                                this.listCauHoi = res.data.data;
                            } else {

                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                xoa(id){
                    if(confirm("Bạn Có Chắc Chắn Muốn Xóa Câu Hỏi Này Không?")){
                        axios
                        .post('/admin/question/delete/'+id,id)
                        .then((res) => {
                         if(res.data.status){
                            toastr.success(res.data.message);
                            this.load();
                        } else {
                            toastr.error(res.data.message);
                        }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                    }else{
                        toastr.error("Lệnh Đã Hủy Bỏ");
                    }
                }

            },
        });
    </script>
@endsection
