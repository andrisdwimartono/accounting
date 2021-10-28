@extends("paging.main")

@section("content")
                <form id="quickForm" action="#">
                @csrf
                    <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="product_name">Nama</label>
                                <div class="col-sm-6">
                                    <input type="text" name="product_name" class="form-control" id="product_name" placeholder="Enter Nama" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"></label>
                                <div class="input-group col-sm-6">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="upload_product_photo" name="upload_product_photo" onchange="selectingfile('product_photo');">
                                        <label class="custom-file-label" for="upload_product_photo">Pilih file Foto Produk</label>
                                    </div>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="btn_product_photo" disabled>Upload</button>
                                    </div>
                                </div>
                                <input type="hidden" class="custom-file-input" id="product_photo" name="product_photo">    
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="produce_code">Kode Produksi</label>
                                <div class="col-sm-6">
                                    <input type="text" name="produce_code" class="form-control" id="produce_code" placeholder="Enter Kode Produksi" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="uom">Satuan</label>
                                <div class="col-sm-6">
                                    <select name="uom" id="uom" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                    </select>
                                    <input type="hidden" name="uom_label" id="uom_label">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="category">Kategori</label>
                                <div class="col-sm-6">
                                    <select name="category" id="category" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                    </select>
                                    <input type="hidden" name="category_label" id="category_label">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="buying_price">Harga Beli</label>
                                <div class="col-sm-6">
                                    <input type="text" name="buying_price" class="form-control cakautonumeric cakautonumeric-float" id="buying_price" value="0" placeholder="Enter Harga Beli" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="selling_price">Harga Jual</label>
                                <div class="col-sm-6">
                                    <input type="text" name="selling_price" class="form-control cakautonumeric cakautonumeric-float" id="selling_price" value="0" placeholder="Enter Harga Jual" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="discount_percentage">Persen Diskon</label>
                                <div class="col-sm-6">
                                    <input type="text" name="discount_percentage" class="form-control cakautonumeric cakautonumeric-float" id="discount_percentage" value="0" placeholder="Enter Persen Diskon" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="discount">Nominal Diskon</label>
                                <div class="col-sm-6">
                                    <input type="text" name="discount" class="form-control cakautonumeric cakautonumeric-float" id="discount" value="0" placeholder="Enter Nominal Diskon" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="status">Status</label>
                                <div class="col-sm-6">
                                    <select name="status" id="status" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                    </select>
                                    <input type="hidden" name="status_label" id="status_label">
                                </div>
                            </div>
                        <div class="form-group">
                            <label for="product_stock">Stok Produk</label>
                            <div id="result">
                                Event result:
                            </div>
                            <table id="ctproduct_stock" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Gudang</th>
                                        <th>Gudang Label</th>
                                        <th>Stok</th>
                                        <th>Action</th>
                                        <th>id</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <input type="hidden" name="product_stock" class="form-control" id="product_stock" placeholder="Enter Menu Field" @if($page_data["page_method_name"] == "View") readonly @endif>
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
                <!-- Modal Stok Produk -->
                <div class="modal fade bd-example-modal-lg" id="staticBackdrop_product_stock" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" data-focus="false" role="dialog" aria-labelledby="staticBackdrop_product_stock_Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdrop_product_stock_Label">Stok Produk</h5>
                            <button type="button" id="staticBackdrop_product_stock_Close" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                        </div>
                        <div class="modal-body">
                            <form id="quickModalForm_product_stock" action="#">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="warehouse">Gudang</label>
                                    <div class="col-sm-6">
                                        <select name="warehouse" id="warehouse" class="form-control select2bs4staticBackdrop" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                        </select>
                                        <input type="hidden" name="warehouse_label" id="warehouse_label">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="stock">Stok</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="stock" value="0" class="form-control cakautonumeric cakautonumeric-float" id="stock" placeholder="Enter Stok" @if($page_data["page_method_name"] == "View") readonly @endif>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Stok Produk End -->
@endsection