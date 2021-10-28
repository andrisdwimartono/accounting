@extends("paging.main")

@section("content")
                <form id="quickForm" action="#">
                @csrf
                    <div class="card-body">
                            <div class="form-group row" id="fg_purchasing_name">
                                <label class="col-sm-4 col-form-label" for="purchasing_name">Kode Pengadaan</label>
                                <div class="col-sm-6">
                                    <input type="text" name="purchasing_name" class="form-control" id="purchasing_name" placeholder="PURC-XXXXX" readonly>
                                </div>
                            </div>
                            <div class="form-group row" id="fg_purchasing_status">
                                <label class="col-sm-4 col-form-label" for="purchasing_status">Status Pengadaan</label>
                                <div class="col-sm-6">
                                    <input type="text" name="purchasing_status" class="form-control" id="purchasing_status" placeholder="Belum Lunas" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="purchasing_datetime">Waktu Pengadaan</label>
                                <div class="col-sm-6" id="reservationdatetime_purchasing_datetime" data-target-input="nearest">
                                    <input type="text" name="purchasing_datetime" id="purchasing_datetime" class="form-control datetimepicker-input" data-target="#reservationdatetime_purchasing_datetime">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="supplier">Pemasok/Supplier</label>
                                <div class="col-sm-6">
                                    <select name="supplier" id="supplier" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                    </select>
                                    <input type="hidden" name="supplier_label" id="supplier_label">
                                </div>
                            </div>
                        <div class="form-group">
                            <label for="ct1_purchasing_detail">Detail Pengadaan</label>
                            <div id="result">
                                Event result:
                            </div>
                            <table id="ctct1_purchasing_detail" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Produk</th>
                                        <th>Produk Label</th>
                                        <th>Harga Beli</th>
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
                            <input type="hidden" name="ct1_purchasing_detail" class="form-control" id="ct1_purchasing_detail" placeholder="Enter Menu Field" @if($page_data["page_method_name"] == "View") readonly @endif>
                        </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="purchasing_detail_total">Total Detail Pengadaan</label>
                                <div class="col-sm-6">
                                    <input type="text" name="purchasing_detail_total" class="form-control cakautonumeric cakautonumeric-float" id="purchasing_detail_total" placeholder="Enter Total Detail Pengadaan" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="purchasing_discount_percentage">Persen Diskon Pengadaan</label>
                                <div class="col-sm-6">
                                    <input type="text" name="purchasing_discount_percentage" class="form-control cakautonumeric cakautonumeric-float" id="purchasing_discount_percentage" placeholder="Enter Persen Diskon Pengadaan" @if($page_data["page_method_name"] == "Create" || $page_data["page_method_name"] == "Edit") value="0" @endif @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="purchasing_discount_total">Nominal Diskon Pengadaan</label>
                                <div class="col-sm-6">
                                    <input type="text" name="purchasing_discount_total" class="form-control cakautonumeric cakautonumeric-float" id="purchasing_discount_total" placeholder="Enter Nominal Diskon Pengadaan" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="purchasing_total">Total Pengadaan</label>
                                <div class="col-sm-6">
                                    <input type="text" name="purchasing_total" class="form-control cakautonumeric cakautonumeric-float" id="purchasing_total" placeholder="Enter Total Pengadaan" readonly>
                                </div>
                            </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6 custom-control custom-checkbox" style="padding-left: 50px;">
                                <input type="checkbox" name="is_paynow" class="custom-control-input" id="is_paynow" @if($page_data["page_method_name"] == "View") disabled="disabled" @endif>
                                <label class="custom-control-label" for="is_paynow">Langsung Bayar?</label>
                        </div>
                        <div class="form-group" id="fg_ct2_payment_detail">
                            <label for="ct2_payment_detail">Detil Pembelian</label>
                            <div id="result">
                                Event result:
                            </div>
                            <table id="ctct2_payment_detail" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tipe Pembelian</th>
                                        <th>Metode Pembelian</th>
                                        <th>Metode Pembelian Label</th>
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
                            <div class="form-group row" id="fg_buying_total">
                                <label class="col-sm-4 col-form-label" for="buying_total">Total Pembelian</label>
                                <div class="col-sm-6">
                                    <input type="text" name="buying_total" class="form-control cakautonumeric cakautonumeric-float" id="buying_total" placeholder="Enter Total Pembelian" @if($page_data["page_method_name"] == "Create" || $page_data["page_method_name"] == "Edit") Value="0" @endif readonly>
                                </div>
                            </div>
                            <div class="form-group row" id="fg_change_total">
                                <label class="col-sm-4 col-form-label" for="change_total">Total Kembalian</label>
                                <div class="col-sm-6">
                                    <input type="text" name="change_total" class="form-control cakautonumeric cakautonumeric-float" id="change_total" placeholder="Enter Total Kembalian" @if($page_data["page_method_name"] == "Create" || $page_data["page_method_name"] == "Edit") Value="0" @endif readonly>
                                </div>
                            </div>
                            <div class="form-group row" id="fg_buying_datetime">
                                <label class="col-sm-4 col-form-label" for="buying_datetime">Waktu Pembelian</label>
                                <div class="col-sm-6" id="reservationdatetime_buying_datetime" data-target-input="nearest">
                                    <input type="text" name="buying_datetime" id="buying_datetime" class="form-control datetimepicker-input" data-target="#reservationdatetime_buying_datetime">
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
                <!-- Modal Detail Pengadaan -->
                <div class="modal fade bd-example-modal-lg" id="staticBackdrop_ct1_purchasing_detail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" data-focus="false" role="dialog" aria-labelledby="staticBackdrop_ct1_purchasing_detail_Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdrop_ct1_purchasing_detail_Label">Detail Pengadaan</h5>
                            <button type="button" id="staticBackdrop_ct1_purchasing_detail_Close" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                        </div>
                        <div class="modal-body">
                            <form id="quickModalForm_ct1_purchasing_detail" action="#">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="product">Produk</label>
                                    <div class="col-sm-6">
                                        <select name="product" id="product" class="form-control select2bs4staticBackdrop" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                        </select>
                                        <input type="hidden" name="product_label" id="product_label">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="purchasing_price">Harga Beli</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="purchasing_price" class="form-control cakautonumeric cakautonumeric-float" id="purchasing_price" placeholder="Enter Harga Beli" @if($page_data["page_method_name"] == "View") readonly @endif>
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
            <!-- Modal Detail Pengadaan End -->
            <!-- Modal Detil Pembelian -->
            <div class="modal fade bd-example-modal-lg" id="staticBackdrop_ct2_payment_detail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" data-focus="false" role="dialog" aria-labelledby="staticBackdrop_ct2_payment_detail_Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdrop_ct2_payment_detail_Label">Detil Pembelian</h5>
                            <button type="button" id="staticBackdrop_ct2_payment_detail_Close" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                        </div>
                        <div class="modal-body">
                            <form id="quickModalForm_ct2_payment_detail" action="#">
                                <input type="hidden" name="payment_type" id="payment_type" value="purchasing">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="paying_method">Metode Pembelian</label>
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
            <!-- Modal Detil Pembelian End -->
@endsection