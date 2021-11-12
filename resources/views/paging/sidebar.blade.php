              <!-- Sidebar  -->
              <!-- <nav id="sidebar">
                <div class="sidebar-header">
                    <h3>ACCOUNTING</h3>
                    <strong>AC</strong>
                </div>

                <ul class="list-unstyled components" id="cakleftmenuside">
                  <li>
                    <a href="/user" class="caksidemenu">
                      <i class="nav-icon fas fa-user"></i>
                      <span> User</span>
                    </a>
                  </li>
                  <li>
                    <a href="/unitkerja" class="caksidemenu">
                      <i class="nav-icon fas fa-building"></i>
                      <span> Unit Kerja</span>
                    </a>
                  </li>
                  <li>
                    <a href="/coa" class="caksidemenu">
                      <i class="nav-icon fas fa-book"></i>
                      <span> COA</span>
                    </a>
                  </li>
                  <li>
                    <a href="/transaction" class="caksidemenu">
                      <i class="nav-icon fas fa-receipt"></i>
                      <span> Transaksi</span>
                    </a>
                  </li>
              </ul>
            </nav> -->

            <!--**********************************
            Sidebar Fixed
        ***********************************-->
		<div class="fixed-content-box">
			<div class="head-name">
				MotaAdmin
				<span class="close-fixed-content fa-left d-lg-none">
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><polygon points="0 0 24 0 24 24 0 24"/><rect fill="#000000" opacity="0.3" transform="translate(15.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-15.000000, -12.000000) " x="14" y="7" width="2" height="10" rx="1"/><path d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997) "/></g></svg>
				</span>
			</div>
			<div class="fixed-content-body dz-scroll" id="DZ_W_Fixed_Contant">
				<div class="tab-content" id="menu">
					<div class="tab-pane chart-sidebar fade show active" id="dashboard-area" role="tabpanel"></div>
					<div class="tab-pane fade" id="cakmenumaster">
						<ul class="metismenu tab-nav-menu">
							<li class="nav-label">Master</li>
							<li id="cakmenuuser"><a href="/user">
									<svg id="icon-apps" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
									User
								</a>
							</li>
							<li id="cakmenuunitkerja"><a href="/unitkerja">
									<svg id="icon-home1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
									Unit Kerja
								</a>
							</li>
							<li id="cakmenucoa"><a href="/coa/aset/list">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<rect x="0" y="0" width="24" height="24"/>
									<path d="M10.5,5 L19.5,5 C20.3284271,5 21,5.67157288 21,6.5 C21,7.32842712 20.3284271,8 19.5,8 L10.5,8 C9.67157288,8 9,7.32842712 9,6.5 C9,5.67157288 9.67157288,5 10.5,5 Z M10.5,10 L19.5,10 C20.3284271,10 21,10.6715729 21,11.5 C21,12.3284271 20.3284271,13 19.5,13 L10.5,13 C9.67157288,13 9,12.3284271 9,11.5 C9,10.6715729 9.67157288,10 10.5,10 Z M10.5,15 L19.5,15 C20.3284271,15 21,15.6715729 21,16.5 C21,17.3284271 20.3284271,18 19.5,18 L10.5,18 C9.67157288,18 9,17.3284271 9,16.5 C9,15.6715729 9.67157288,15 10.5,15 Z" fill="#000000"/>
									<path d="M5.5,8 C4.67157288,8 4,7.32842712 4,6.5 C4,5.67157288 4.67157288,5 5.5,5 C6.32842712,5 7,5.67157288 7,6.5 C7,7.32842712 6.32842712,8 5.5,8 Z M5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 C6.32842712,10 7,10.6715729 7,11.5 C7,12.3284271 6.32842712,13 5.5,13 Z M5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 C6.32842712,15 7,15.6715729 7,16.5 C7,17.3284271 6.32842712,18 5.5,18 Z" fill="#000000" opacity="0.3"/>
								</g>
							</svg>
									Kode Rek. Akuntansi
								</a>
							</li>
						</ul>
					</div>
					<div class="tab-pane fade" id="cakmenujurnals">
						<ul class="metismenu tab-nav-menu">
							<li class="nav-label">Jurnal</li>
							<li id="cakmenuuser"><a href="/jurnal">
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24"/>
											<path d="M13.6855025,18.7082217 C15.9113859,17.8189707 18.682885,17.2495635 22,17 C22,16.9325178 22,13.1012863 22,5.50630526 L21.9999762,5.50630526 C21.9999762,5.23017604 21.7761292,5.00632908 21.5,5.00632908 C21.4957817,5.00632908 21.4915635,5.00638247 21.4873465,5.00648922 C18.658231,5.07811173 15.8291155,5.74261533 13,7 C13,7.04449645 13,10.79246 13,18.2438906 L12.9999854,18.2438906 C12.9999854,18.520041 13.2238496,18.7439052 13.5,18.7439052 C13.5635398,18.7439052 13.6264972,18.7317946 13.6855025,18.7082217 Z" fill="#000000"/>
											<path d="M10.3144829,18.7082217 C8.08859955,17.8189707 5.31710038,17.2495635 1.99998542,17 C1.99998542,16.9325178 1.99998542,13.1012863 1.99998542,5.50630526 L2.00000925,5.50630526 C2.00000925,5.23017604 2.22385621,5.00632908 2.49998542,5.00632908 C2.50420375,5.00632908 2.5084219,5.00638247 2.51263888,5.00648922 C5.34175439,5.07811173 8.17086991,5.74261533 10.9999854,7 C10.9999854,7.04449645 10.9999854,10.79246 10.9999854,18.2438906 L11,18.2438906 C11,18.520041 10.7761358,18.7439052 10.4999854,18.7439052 C10.4364457,18.7439052 10.3734882,18.7317946 10.3144829,18.7082217 Z" fill="#000000" opacity="0.3"/>
										</g>
									</svg>
									Jurnal
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="tab-pane chart-sidebar fade show active" role="tabpanel">
					<div class="card">
						<div class="card-header align-items-start">
							<div>
								<h6>Daily Sales</h6>
								<p>Check out each colum for more details</p>
							</div>
							<span class="btn btn-primary light sharp ml-2">
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="13" rx="1.5"/><rect fill="#000000" opacity="0.3" x="7" y="9" width="3" height="8" rx="1.5"/><path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero"/><rect fill="#000000" opacity="0.3" x="17" y="11" width="3" height="6" rx="1.5"/></g></svg>
							</span>
						</div>
						<div class="card-body">
							<canvas id="daily-sales-chart" height="85" style="height:85px;"></canvas>
						</div>
					</div>
					<div class="card bg-warning-light">
						<div class="card-header align-items-start mb-3">
							<div>
								<h6>Profit Share</h6>
								<p>Check out each colum for more details</p>
							</div>
							<span class="btn btn-warning light sharp ml-2">
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><path d="M4.00246329,12.2004927 L13,14 L13,4.06189375 C16.9463116,4.55399184 20,7.92038235 20,12 C20,16.418278 16.418278,20 12,20 C7.64874861,20 4.10886412,16.5261253 4.00246329,12.2004927 Z" fill="#000000" opacity="0.3"/><path d="M3.0603968,10.0120794 C3.54712466,6.05992157 6.91622084,3 11,3 L11,11.6 L3.0603968,10.0120794 Z" fill="#000000"/></g></svg>
							</span>
						</div>
						<div class="card-body">
							<div class="chart-point">
								<div class="check-point-area">
									<canvas id="ShareProfit"></canvas>
								</div>
								<ul class="chart-point-list">
									<li><i class="fa fa-circle text-primary mr-1"></i> 40% Tickets</li>
									<li><i class="fa fa-circle text-success mr-1"></i> 35% Events</li>
									<li><i class="fa fa-circle text-warning mr-1"></i> 25% Other</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="card bg-info-light">
						<div class="card-header align-items-start mb-3">
							<div>
								<h6>Visitors By Browser</h6>
								<p>Check out each colum for more details</p>
							</div>
							<span class="btn btn-info light sharp ml-2">
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><path d="M3,4 L20,4 C20.5522847,4 21,4.44771525 21,5 L21,7 C21,7.55228475 20.5522847,8 20,8 L3,8 C2.44771525,8 2,7.55228475 2,7 L2,5 C2,4.44771525 2.44771525,4 3,4 Z M10,10 L20,10 C20.5522847,10 21,10.4477153 21,11 L21,19 C21,19.5522847 20.5522847,20 20,20 L10,20 C9.44771525,20 9,19.5522847 9,19 L9,11 C9,10.4477153 9.44771525,10 10,10 Z" fill="#000000"/><rect fill="#000000" opacity="0.3" x="2" y="10" width="5" height="10" rx="1"/></g></svg>
							</span>
						</div>
						<div class="card-body">
							<p class="mb-2 d-flex"><img width="22" height="22" src="{{ asset ("/assets/motaadmin/images/browser/icon1.png") }} " class="mr-2" alt=""/>Photoshop
								<span class="pull-right text-warning ml-auto">85%</span>
							</p>
							<div class="progress mb-3" style="height:4px">
								<div class="progress-bar bg-warning progress-animated" style="width:85%; height:4px;" role="progressbar">
									<span class="sr-only">60% Complete</span>
								</div>
							</div>
							<p class="mb-2 d-flex"><img width="22" height="22" src="{{ asset ("/assets/motaadmin/images/browser/icon2.png") }} " class="mr-2" alt=""/>Code editor
								<span class="pull-right text-success ml-auto">90%</span>
							</p>
							<div class="progress mb-3" style="height:4px">
								<div class="progress-bar bg-success progress-animated" style="width:90%; height:4px;" role="progressbar">
									<span class="sr-only">60% Complete</span>
								</div>
							</div>
							<p class="mb-2 d-flex"><img width="22" height="22" src="{{ asset ("/assets/motaadmin/images/browser/icon1.png") }} " class="mr-2" alt=""/>Illustrator
								<span class="pull-right text-danger ml-auto">65%</span>
							</p>
							<div class="progress" style="height:4px">
								<div class="progress-bar bg-danger progress-animated" style="width:65%; height:4px;" role="progressbar">
									<span class="sr-only">60% Complete</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--**********************************
            Sidebar End
        ***********************************-->