@extends('Admin.master')
@section('noi_dung')
    <div class="row mt-5 sm-12" id="app">
        <table>
            <tr>
                <td colspan="4">
                    <input type="search" v-model="searchKey" v-on:keyup="tim()" class="form-control text-darkmod text-center"
                        placeholder="Tìm Kiếm Username" />
                </td>
            </tr>
            <tr>
                <th class="text-center">username</th>
                <th class="text-center">Email</th>
                <th class="text-center">Coin</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
            </tr>
            <tr v-for="(v,k) in listKH">
                <td class="text-center">@{{ v.username }}</td>
                <td class="text-center">@{{ v.email }}</td>
                {{-- <td class="text-center">@{{ chuyenTien(v.coin) }}</td> --}}
                <td class="text-center">
                    <input type="number" v-model="v.coin" @change="updateCoin(v.id, v.coin)"
                        class="form-control text-darkmod">
                </td>
                <td v-if="v.status==1" class="text-center">
                    <Button v-on:click="change(v.id)" class="btn btn-info">Hoạt Động</Button>
                </td>
                <td v-else class="text-center">
                    <Button v-on:click="change(v.id)" class="btn btn-danger">Đã Khóa</Button>
                </td>
                <td class="text-center">
                    <button class="btn btn-danger">Xóa</button>
                </td>
            </tr>
        </table>
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
                this.load();
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
                load() {
                    // fetch('https://testapi.jasonwatmore.com/products')
                    //     .then((res) => {
                    //         console.log(res.json());
                    //     });
                    axios
                        .post('/admin/khach-hang/data', 1)
                        .then((res) => {
                            if (res.data.status) {
                                this.listKH = res.data.data;
                            } else {
                                // toastr.error(res.data.message);
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
