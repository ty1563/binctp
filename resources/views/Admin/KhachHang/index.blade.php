@extends('Admin.master')

@section('noi_dung')
    <div class="row" id="app">
        <div class="mt-3">
            <table class="table">
                <input type="search" v-model="searchKey" v-on:keyup="tim()" class="form-control text-darkmod text-center"
                    placeholder="Tìm Kiếm Username" />
                <tr>
                    <td class="text-center bold-text">#</td>
                    <td class="text-center bold-text">Username</td>
                    <td v-if="view>767" class="text-center bold-text">email</td>
                    <td class="text-center bold-text">Coin</td>
                    <td class="text-center bold-text">Tình Trạng</td>
                    <td class="text-center bold-text">Action</td>
                </tr>
                <tr v-for="(v,k) in listKH">
                    <td class="text-center">@{{ k + 1 }}</td>
                    <td class="text-center">@{{ v.username }}</td>
                    <td v-if="view>767" class="text-center">@{{ v.email }}</td>
                    {{-- <td class="text-center">@{{ chuyenTien(v.coin) }}</td> --}}
                    <td class="text-center">
                        <input type="number" v-model="v.coin" @change="updateCoin(v.id, v.coin)"
                            class="text-darkmod text-center">
                    </td>
                    <td v-if="v.status==1" class="text-center">
                        <Button v-on:click="change(v.id)" class="btn btn-info">Mở</Button>
                    </td>
                    <td v-else class="text-center">
                        <Button v-on:click="change(v.id)" class="btn btn-danger">Khóa</Button>
                    </td>
                    <td class="text-center">
                        {{-- <button v-on:click="edit = v" type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#infoo">
                                Cập Nhật
                        </button> --}}
                        <button class="btn btn-danger">Xóa</button>
                    </td>
                </tr>
            </table>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item" :class="{ 'disabled': !pagination.prev_page_url }">
                        <a class="page-link" href="#" v-on:click="load(pagination.current_page - 1)">Trang Trước</a>
                    </li>
                    <li class="page-item" :class="{ 'disabled': !pagination.next_page_url }">
                        <a class="page-link" href="#" v-on:click="load(pagination.current_page + 1)">Trang Kế</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                listKH: [],
                searchKey: null,
                view: window.innerWidth,
            },
            created() {
                this.load(1);
            },
            methods: {
                updateCoin(id, coin) {
                    var data = {
                        'id': id,
                        'coin': coin,
                    };
                    axios
                        .post('/admin/khach-hang/update', data)
                        .then((res) => {
                            if (res.data.status) {
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
                chuyenTien(soTien) {
                    const formatter = new Intl.NumberFormat('vi-VN', {
                        style: 'currency',
                        currency: 'VND'
                    });
                    return formatter.format(soTien);
                },
                change(id) {
                    axios
                        .post('/admin/khach-hang/change/' + id, id)
                        .then((res) => {
                            if (res.data.status) {
                                this.load();
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
                load(page) {
                    axios
                        .post('/admin/khach-hang/data?page=' + page)
                        .then((res) => {
                            if (res.data.status) {
                                this.listKH = res.data.data.data;
                                this.pagination = res.data.data;
                            } else {

                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                tim() {
                    var data = {
                        'searchKey': this.searchKey,
                    };
                    axios
                        .post('/admin/khach-hang/search', data)
                        .then((res) => {
                            if (res.data.status) {
                                this.listKH = res.data.data;
                            } else {
                                toastr.error(res.data.message);
                                this.load();
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
