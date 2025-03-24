<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-lg-6 main-header">
				<h2> اضافة زي جديد</h2>
			</div>
		</div>
	</div>
</div>
<style>
	@media (max-width: 768px) {
  #uniformsTable thead {
    display: none;
  }

  #uniformsTable tr {
    display: block;
    margin-bottom: 1rem;
  }

  #uniformsTable td {
    display: flex;
    justify-content: space-between;
    padding: 10px;
    border: 1px solid #ddd;
  }

  #uniformsTable td:before {
    content: attr(data-label);
    flex-basis: 40%;
    font-weight: bold;
    text-align: center;
  }
}

#uniformsTable td {
  font-size: 14px;

}

.addRow, .removeRow, .SaveRow, .EditRow {
  margin: 5px 0;
}

</style>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h5>اضافة زي جديد</h5>
					<div class="card-header-right">
						<button type="button" class="btn btn-primary" id="scanQR">ماسح QR</button>
					</div>
				</div>
				<div class="card-body">
					<form id="addUniformForm">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="inputState"> أدخل رقم المنخرط <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="member_idInput" placeholder="أدخل رقم المنخرط">
							</div>
							<div class="form-group col-md-6">
								<label for="inputState">المنخرط<span class="text-danger">*</span></label>
								<select id="member_idSelect" class="form-control"></select>
							</div>
							<hr>
							<div class="col-12 TableAddUniform d-none">
								<div class="table-responsive">
									<table class="table table-bordered table-striped text-center" id="uniformsTable">
										<thead>
											<tr>
												<th>الزي</th>
												<th>الحجم</th>
												<th>السعر</th>
												<th>مدفوع</th>
												<th>المستلم</th>
												<th>الملاحظات</th>
												<th>حذف</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td colspan="7">
													<button type="button" class="btn btn-success addRow"><i class="fa fa-plus"></i></button>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>