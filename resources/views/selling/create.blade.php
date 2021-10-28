@extends("paging.main")

@section("content")
                <form id="quickForm" action="#">
                @csrf
                    <div class="card-body">
                            <div class="form-group row" id="fg_selling_name">
                                <label class="col-sm-4 col-form-label" for="selling_name">Kode Penjualan</label>
                                <div class="col-sm-6">
                                    <input type="text" name="selling_name" class="form-control" id="selling_name" placeholder="SELL-XXXXX" readonly>
                                </div>
                            </div>
                            <div class="form-group row" id="fg_selling_status">
                                <label class="col-sm-4 col-form-label" for="selling_status">Status Penjualan</label>
                                <div class="col-sm-6">
                                    <input type="text" name="selling_status" class="form-control" id="selling_status" placeholder="Belum Lunas" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="selling_datetime">Waktu Penjualan</label>
                                <div class="col-sm-6" id="reservationdatetime_selling_datetime" data-target-input="nearest">
                                    <input type="text" name="selling_datetime" id="selling_datetime" class="form-control datetimepicker-input" data-target="#reservationdatetime_selling_datetime">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="customer">Pelanggan</label>
                                <div class="col-sm-5">
                                    <select name="customer" id="customer" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                    </select>
                                    <input type="hidden" name="customer_label" id="customer_label">
                                </div>
                                <div class="col-sm-1">
                                <input id="single2" type="hidden" size="50">
                                <button type="button" id="openreader-single2" 
                                data-qrr-target="#single2" 
                                data-qrr-audio-feedback="true"><i class="fas fa-qrcode"></i></button>
                                </div>
                            </div>
                        <div class="form-group">
                            <label for="ct1_selling_detail">Detail Penjualan</label>
                            <div id="result">
                                Event result:
                            </div>
                            <table id="ctct1_selling_detail" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Produk / Bundle</th>
                                        <th>Produk / Bundle Label</th>
                                        <th>Apakah Bundle?</th>
                                        <th>Produk</th>
                                        <th>Produk Label</th>
                                        <th>Bundle</th>
                                        <th>Bundle Label</th>
                                        <th>Harga Jual</th>
                                        <th>Kuantitas</th>
                                        <th>Persen Diskon</th>
                                        <th>Nominal Diskon</th>
                                        <th>Total</th>
                                        <th>Gudang</th>
                                        <th>Gudang Label</th>
                                        <th>Action</th>
                                        <th>id</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <input type="hidden" name="ct1_selling_detail" class="form-control" id="ct1_selling_detail" placeholder="Enter Menu Field" @if($page_data["page_method_name"] == "View") readonly @endif>
                        </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="selling_detail_total">Total Detail Penjualan</label>
                                <div class="col-sm-6">
                                    <input type="text" name="selling_detail_total" class="form-control cakautonumeric cakautonumeric-float" id="selling_detail_total" placeholder="Enter Total Detail Penjualan" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="selling_discount_percentage">Persen Diskon Penjualan</label>
                                <div class="col-sm-6">
                                    <input type="text" name="selling_discount_percentage" class="form-control cakautonumeric cakautonumeric-float" id="selling_discount_percentage" placeholder="Enter Persen Diskon Penjualan" @if($page_data["page_method_name"] == "Create" || $page_data["page_method_name"] == "Edit") value="0" @endif @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="selling_discount_total">Nominal Diskon Penjualan</label>
                                <div class="col-sm-6">
                                    <input type="text" name="selling_discount_total" class="form-control cakautonumeric cakautonumeric-float" id="selling_discount_total" placeholder="Enter Nominal Diskon Penjualan" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="selling_total">Total Penjualan</label>
                                <div class="col-sm-6">
                                    <input type="text" name="selling_total" class="form-control cakautonumeric cakautonumeric-float" id="selling_total" placeholder="Enter Total Penjualan" readonly>
                                </div>
                            </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6 custom-control custom-checkbox" style="padding-left: 50px;">
                                <input type="checkbox" name="is_paynow" class="custom-control-input" id="is_paynow" @if($page_data["page_method_name"] == "View") disabled="disabled" @endif>
                                <label class="custom-control-label" for="is_paynow">Langsung Bayar?</label>
                        </div>
                        <div class="form-group" id="fg_ct2_payment_detail">
                            <label for="ct2_payment_detail">Detil Pembayaran</label>
                            <div id="result">
                                Event result:
                            </div>
                            <table id="ctct2_payment_detail" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tipe Pembayaran</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Metode Pembayaran Label</th>
                                        <th>Nominal Bayar</th>
                                        <th>Catatan</th>
                                        <th>Action</th>
                                        <th>id</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <input type="hidden" name="ct2_payment_detail" class="form-control" id="ct2_payment_detail" placeholder="Enter Menu Field" @if($page_data["page_method_name"] == "View") readonly @endif>
                        </div>
                        </div>
                            <div class="form-group row" id="fg_paying_total">
                                <label class="col-sm-4 col-form-label" for="paying_total">Total Pembayaran</label>
                                <div class="col-sm-6">
                                    <input type="text" name="paying_total" class="form-control cakautonumeric cakautonumeric-float" id="paying_total" placeholder="Enter Total Pembayaran" @if($page_data["page_method_name"] == "Create" || $page_data["page_method_name"] == "Edit") Value="0" @endif readonly>
                                </div>
                            </div>
                            <div class="form-group row" id="fg_change_total">
                                <label class="col-sm-4 col-form-label" for="change_total">Total Kembalian</label>
                                <div class="col-sm-6">
                                    <input type="text" name="change_total" class="form-control cakautonumeric cakautonumeric-float" id="change_total" placeholder="Enter Total Kembalian" @if($page_data["page_method_name"] == "Create" || $page_data["page_method_name"] == "Edit") Value="0" @endif readonly>
                                </div>
                            </div>
                            <div class="form-group row" id="fg_paying_datetime">
                                <label class="col-sm-4 col-form-label" for="paying_datetime">Waktu Pembayaran</label>
                                <div class="col-sm-6" id="reservationdatetime_paying_datetime" data-target-input="nearest">
                                    <input type="text" name="paying_datetime" id="paying_datetime" class="form-control datetimepicker-input" data-target="#reservationdatetime_paying_datetime">
                                </div>
                            </div>
                    </div>
                    @if($page_data["page_method_name"] != "View")
                    <div class="form-group row">
                        <div class="col-sm-9 offset-sm-9">
                        <button type="submit" class="btn btn-primary" @if($page_data["page_method_name"] == "View") readonly @endif>Submit</button>
                        </div>
                    </div>
                    @else
                    <div class="form-group row">
                        <div class="col-sm-9 offset-sm-9">

                        </div>
                    </div>
                    @endif
                </form>
                <!-- Modal Detail Penjualan -->
                <div class="modal fade bd-example-modal-lg" id="staticBackdrop_ct1_selling_detail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" data-focus="false" role="dialog" aria-labelledby="staticBackdrop_ct1_selling_detail_Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdrop_ct1_selling_detail_Label">Detail Penjualan</h5>
                            <button type="button" id="staticBackdrop_ct1_selling_detail_Close" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                        </div>
                        <div class="modal-body">
                            <form id="quickModalForm_ct1_selling_detail" action="#">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="product_or_bundle">Produk / Bundle</label>
                                    <div class="col-sm-6">
                                        <select name="product_or_bundle" id="product_or_bundle" class="form-control select2bs4staticBackdrop" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                        </select>
                                        <input type="hidden" name="product_or_bundle_label" id="product_or_bundle_label">
                                    </div>
                                </div>
                                <input type="hidden" name="is_bundle" id="is_bundle">
                                <input type="hidden" name="product" id="product">
                                <input type="hidden" name="product_label" id="product_label">
                                <input type="hidden" name="bundle" id="bundle">
                                <input type="hidden" name="bundle_label" id="bundle_label">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="selling_price">Harga Jual</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="selling_price" class="form-control cakautonumeric cakautonumeric-float" id="selling_price" placeholder="Enter Harga Jual" @if($page_data["page_method_name"] == "View") readonly @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="warehouse">Gudang</label>
                                    <div class="col-sm-6">
                                        <select name="warehouse" id="warehouse" class="form-control select2bs4staticBackdrop" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                        </select>
                                        <input type="hidden" name="warehouse_label" id="warehouse_label">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="available_stock">Sisa</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="available_stock" class="form-control cakautonumeric cakautonumeric-float" id="available_stock" placeholder="Sisa" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="quantity">Kuantitas</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="quantity" class="form-control cakautonumeric cakautonumeric-float" id="quantity" placeholder="Enter Kuantitas" @if($page_data["page_method_name"] == "View") readonly @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="discount_percentage">Persen Diskon</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="discount_percentage" class="form-control cakautonumeric cakautonumeric-float" id="discount_percentage" placeholder="Enter Persen Diskon" @if($page_data["page_method_name"] == "View") readonly @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="discount_total">Nominal Diskon</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="discount_total" class="form-control cakautonumeric cakautonumeric-float" id="discount_total" placeholder="Enter Nominal Diskon" @if($page_data["page_method_name"] == "View") readonly @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="total">Total</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="total" class="form-control cakautonumeric cakautonumeric-float" id="total" placeholder="Enter Total" readonly>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Detail Penjualan End -->
            <!-- Modal Detil Pembayaran -->
            <div class="modal fade bd-example-modal-lg" id="staticBackdrop_ct2_payment_detail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" data-focus="false" role="dialog" aria-labelledby="staticBackdrop_ct2_payment_detail_Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdrop_ct2_payment_detail_Label">Detil Pembayaran</h5>
                            <button type="button" id="staticBackdrop_ct2_payment_detail_Close" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                        </div>
                        <div class="modal-body">
                            <form id="quickModalForm_ct2_payment_detail" action="#">
                                <input type="hidden" name="payment_type" id="payment_type" value="selling">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="paying_method">Metode Pembayaran</label>
                                    <div class="col-sm-6">
                                        <select name="paying_method" id="paying_method" class="form-control select2bs4staticBackdrop" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                        </select>
                                        <input type="hidden" name="paying_method_label" id="paying_method_label">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="paying">Nominal Bayar</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="paying" class="form-control cakautonumeric cakautonumeric-float" id="paying" placeholder="Enter Nominal Bayar" @if($page_data["page_method_name"] == "View") readonly @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="payment_notes">Catatan</label>
                                    <div class="col-sm-6">
                                        <textarea name="payment_notes" class="form-control" id="payment_notes" placeholder="Enter Catatan" @if($page_data["page_method_name"] == "View") readonly @endif></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Detil Pembayaran End -->
@endsection