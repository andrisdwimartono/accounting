@extends("paging.main")

@section("content")
                <form id="quickForm" action="#">
                @csrf
                    <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="bundle_name">Nama Paket</label>
                                <div class="col-sm-6">
                                    <input type="text" name="bundle_name" class="form-control" id="bundle_name" placeholder="Enter Nama Paket" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="bundle_code">Kode Paket</label>
                                <div class="col-sm-6">
                                    <input type="text" name="bundle_code" class="form-control" id="bundle_code" placeholder="Enter Kode Paket" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                        <div class="form-group">
                            <label for="ct1_bundle_detail">Detail Paket</label>
                            <div id="result">
                                Event result:
                            </div>
                            <table id="ctct1_bundle_detail" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Produk</th>
                                        <th>Produk Label</th>
                                        <th>Kuantitas</th>
                                        <th>Harga Jual</th>
                                        <th>Persen Diskon</th>
                                        <th>Nominal Diskon</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                        <th>id</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <input type="hidden" name="ct1_bundle_detail" class="form-control" id="ct1_bundle_detail" placeholder="Enter Menu Field" @if($page_data["page_method_name"] == "View") readonly @endif>
                        </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="total_price">Harga Jual Paket</label>
                                <div class="col-sm-6">
                                    <input type="text" name="total_price" class="form-control cakautonumeric cakautonumeric-float" id="total_price" value="0" placeholder="Enter Harga Jual Paket" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="discount_percentage_bundle">Persen Diskon Paket</label>
                                <div class="col-sm-6">
                                    <input type="text" name="discount_percentage_bundle" class="form-control cakautonumeric cakautonumeric-float" id="discount_percentage_bundle" value="0" placeholder="Enter Persen Diskon Paket" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="discount_total_bundle">Nominal Diskon</label>
                                <div class="col-sm-6">
                                    <input type="text" name="discount_total_bundle" class="form-control cakautonumeric cakautonumeric-float" id="discount_total_bundle" value="0" placeholder="Enter Nominal Diskon" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="total_bundle">Total</label>
                                <div class="col-sm-6">
                                    <input type="text" name="total_bundle" class="form-control cakautonumeric cakautonumeric-float" id="total_bundle" value="0" placeholder="Enter Total" @if($page_data["page_method_name"] == "View") readonly @endif>
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
                <!-- Modal Detail Paket -->
                <div class="modal fade bd-example-modal-lg" id="staticBackdrop_ct1_bundle_detail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" data-focus="false" role="dialog" aria-labelledby="staticBackdrop_ct1_bundle_detail_Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdrop_ct1_bundle_detail_Label">Detail Paket</h5>
                            <button type="button" id="staticBackdrop_ct1_bundle_detail_Close" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                        </div>
                        <div class="modal-body">
                            <form id="quickModalForm_ct1_bundle_detail" action="#">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="product">Produk</label>
                                    <div class="col-sm-6">
                                        <select name="product" id="product" class="form-control select2bs4staticBackdrop" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                        </select>
                                        <input type="hidden" name="product_label" id="product_label">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="quantity">Kuantitas</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="quantity" value="0" class="form-control cakautonumeric cakautonumeric-float" id="quantity" placeholder="Enter Kuantitas" @if($page_data["page_method_name"] == "View") readonly @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="selling_price">Harga Jual</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="selling_price" value="0" class="form-control cakautonumeric cakautonumeric-float" id="selling_price" placeholder="Enter Harga Jual" @if($page_data["page_method_name"] == "View") readonly @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="discount_percentage">Persen Diskon</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="discount_percentage" value="0" class="form-control cakautonumeric cakautonumeric-float" id="discount_percentage" placeholder="Enter Persen Diskon" @if($page_data["page_method_name"] == "View") readonly @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="discount_total">Nominal Diskon</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="discount_total" value="0" class="form-control cakautonumeric cakautonumeric-float" id="discount_total" placeholder="Enter Nominal Diskon" @if($page_data["page_method_name"] == "View") readonly @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="total">Total</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="total" value="0" class="form-control cakautonumeric cakautonumeric-float" id="total" placeholder="Enter Total" @if($page_data["page_method_name"] == "View") readonly @endif>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Detail Paket End -->
@endsection