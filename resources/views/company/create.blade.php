@extends("paging.main")

@section("content")
                <form id="quickForm" action="#">
                @csrf
                    <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="company_name">Nama Usaha</label>
                                <div class="col-sm-6">
                                    <input type="text" name="company_name" class="form-control" id="company_name" placeholder="Enter Nama Usaha" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="company_email">Email</label>
                                <div class="col-sm-6">
                                    <input type="text" name="company_email" class="form-control" id="company_email" placeholder="Enter Email" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="company_email_password">Password</label>
                                <div class="col-sm-6">
                                    <input type="text" name="company_email_password" class="form-control" id="company_email_password" placeholder="Enter Password" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="address">Alamat</label>
                            <div class="col-sm-6">
                                <textarea name="address" class="form-control" id="address" placeholder="Enter Alamat" @if($page_data["page_method_name"] == "View") readonly @endif></textarea>
                            </div>
                        </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="company_id">Induk Usaha</label>
                                <div class="col-sm-6">
                                    <select name="company_id" id="company_id" class="form-control select2bs4staticBackdrop" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                    </select>
                                    <input type="hidden" name="company_id_label" id="company_id_label">
                                </div>
                            </div>
                    </div>
                    @if($page_data["page_method_name"] != "View")
                    <div class="form-group row">
                        <div class="col-sm-9 offset-sm-4">
                        <button type="submit" class="btn btn-primary" @if($page_data["page_method_name"] == "View") readonly @endif>Submit</button>
                        </div>
                    </div>
                    @else
                    <div class="form-group row">
                        <div class="col-sm-9 offset-sm-4">

                        </div>
                    </div>
                    @endif
                </form>
@endsection