function addRow() {
	var table = document.getElementById("menuTable");
	var row = table.insertRow(-1);
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
	var cell4 = row.insertCell(3);
	var date = new Date();
	cell1.innerHTML = '<div class="form-group"><select id="bahan'+date.getTime()+'" name="menuName[]" class="form-control select2" required></select><input type="hidden" id="id_bahan_before" value="0"></div>';
	cell2.innerHTML = '<div style="display: flex; align-items: center;"> <div class="form-group" style="margin-right: 5px;"> <input class="form-control" type="number" name="qty[]" min="1" required /></div><div><div class="col-auto align-self-center" id="satuan'+date.getTime()+'"></div></div></div>';
	cell3.innerHTML = '<div class="form-group"> <input type="radio" class="form-control" name="isBahanUtama" required /></div>';
	cell4.innerHTML = '<button class="btn btn-info btn-sm" type="button" onclick="removeRow(this)">Remove</button>';
	
	// Muat kembali data ke dropdown setiap kali baris baru ditambahkan
	loadDataToDropdown('#bahan'+date.getTime(), '#satuan'+date.getTime());
}
  
function removeRow(button) {
	var row = button.parentNode.parentNode;
	row.parentNode.removeChild(row);
	console.log('add');
}

function removeRowEdit(button,id_resep) {
	var row = button.parentNode.parentNode;
    var selectElement = row.querySelector('select');
    var id_bahan = selectElement.value;
	
	row.parentNode.removeChild(row);

	$.ajax({
        url: deleteBahan,
        type: 'post',
        data: {
			'id_bahan' : id_bahan,
			'id_resep': id_resep
		},
        success: function(response) {
            // Handle response jika diperlukan
            console.log(response);
        },
        error: function(xhr, status, error) {
            // Handle error jika diperlukan
            console.error(xhr.responseText);
        }
    });

	// console.log('id_bahan', id_bahan);
	// console.log('id_resep', id_resep);
}

function loadDataToDropdown(id, id_satuan) {
	$(id).select2({
		placeholder: "Bahan",
		ajax: {
			url: bahanSearchUrl, // Ganti dengan URL API Anda
			type: "post",
			dataType: "json",
			data: function(params) {
				return {
					bahan: params.term
				};
			},
			processResults: function(data) {
				return {
					results: data
				};
			},
			cache: true
		}
	}).on('change', function() {
		var selectedData = $(id).select2('data')[0];
        $(id_satuan).text('/ '+selectedData.satuan);
    });
}

let url;
let resep = $("#resep").DataTable({
    responsive: true,
    scrollX: true,
    ajax: readUrl,
    columnDefs: [{
        searcable: false,
        orderable: false,
        targets: 0
    }],
    order: [
        [1, "asc"]
    ],
    columns: [
        { data: null },
        { data: "nama" },
        { data: "cost" },
        { data: "action" }
    ]
});

function reloadTable() {
    resep.ajax.reload()
}

//Done
function addData() {
	// Mendapatkan nilai dari inputan formulir
	var id = $('input[name="id"]').val();
	var nama = $('#nama').val();
	var cost = $('#cost').val();
	var menuItemsPromises = [];

	$('#menuTable tbody tr').slice(1).each(function() {
		var menuName = $(this).find('select[name="menuName[]"]').val();
		var qty = $(this).find('input[name="qty[]"]').val();
		var isBahanUtama = $(this).find('input[name="isBahanUtama"]:checked').length > 0;

		var promise = $.ajax({
			url: getBahanUrl,
			method: 'post',
			dataType: 'json',
			data: {id: menuName},
			processResults: true
		}).then(function(res){
			return {
				"menuName": menuName,
				"id": res.id,
				"nama": res.nama,
				"unit": res.unit,
				"satuan": res.satuan,
				"cost": res.unit_cost,
				"qty": qty,
				"isBahanUtama": isBahanUtama,
				"subtotalcost": res.unit_cost*qty
			};
		});
		menuItemsPromises.push(promise);
	});
	// Menunggu semua promise selesai
	Promise.all(menuItemsPromises).then(menuItems => {
		var total = 0;
		for (var i = 0; i < menuItems.length; i++) {
			total += menuItems[i].subtotalcost;
		}

		var totalRupiah = total.toLocaleString('id-ID', {
			style: 'currency',
			currency: 'IDR'
		});

		$('#cost').val(totalRupiah);

		// Manipulate Komponen	
		$('.btn-add').removeClass('btn-success').addClass('btn-warning').text('Submit Resep');
		$('.btn-info').prop('disabled', true);
		$('#nama').prop('disabled', true);
		$('select[name="menuName[]"]').prop('disabled', true);
		$('input[name="qty[]"]').prop('disabled', true);
		$('input[name="isBahanUtama"]').prop('disabled', true);
		$('button.btn-remove').prop('disabled', true);
		$('.btn-add').click(function(event) {
			var formData = {
				"id": id,
				"nama": nama,
				"cost": cost,
				"total": total,
				"menuItems": menuItems
			};
			// var jsonString = JSON.stringify(formData);
			// console.log(jsonString);
			submitResep(formData);
		});
	});
}

//Done
function submitResep(data) {
 	$.ajax({
        url: addUrl,
        type: "post",
        dataType: "json",
        data: data,
        success: res => {
            $(".modal").modal("hide");
            Swal.fire("Sukses", "Sukses Menambahkan Data", "success");
            reloadTable();
			// console.log(res);
        },
        error: res => {
            console.log(res);
        }
    });
}

//Done
function remove(id) {
    Swal.fire({
        title: "Hapus",
        text: "Hapus data ini?",
        type: "warning",
        showCancelButton: true
    }).then((result) => {
		if(result.value === true){
			$.ajax({
				url: deleteUrl,
				type: "post",
				dataType: "json",
				data: {
					id: id
				},
				success: () => {
					Swal.fire("Sukses", "Sukses Menghapus Data", "success");
					reloadTable();
				},
				error: () => {
					console.log();
				}
			});
		}
		else{
			console.log('cancel');	
		}
    })
}

function editData() {
	console.log('edit triggered');
	var id = $('input[name="id"]').val();
	var nama = $('#nama').val();
	var cost = $('#cost').val();

	var menuItemsPromises = [];
	$('#menuTable tbody tr').slice(1).each(function() {
		var menuName = $(this).find('select[name="menuName[]"]').val();
		var qty = $(this).find('input[name="qty[]"]').val();
		var isBahanUtama = $(this).find('input[name="isBahanUtama"]:checked').length > 0;
		var id_bahan_before = $(this).find('input[id="id_bahan_before"]').val();

		var promise = $.ajax({
			url: getBahanUrl,
			method: 'post',
			dataType: 'json',
			data: {id: menuName},
			processResults: true
		}).then(function(res){
			return {
				"menuName": menuName,
				"id": res.id,
				"nama": res.nama,
				"unit": res.unit,
				"satuan": res.satuan,
				"cost": res.unit_cost,
				"qty": qty,
				"isBahanUtama": isBahanUtama,
				"id_bahan_before": id_bahan_before,
				"subtotalcost": res.unit_cost*qty
			};
		});
		menuItemsPromises.push(promise);
	});
	// Menunggu semua promise selesai
	Promise.all(menuItemsPromises).then(menuItems => {
		var total = 0;
		for (var i = 0; i < menuItems.length; i++) {
			total += menuItems[i].subtotalcost;
		}

		var totalRupiah = total.toLocaleString('id-ID', {
			style: 'currency',
			currency: 'IDR'
		});

		$('#cost').val(totalRupiah);

		var formData = {
			"id": id,
			"nama": nama,
			"cost": cost,
			"total": total,
			"menuItems": menuItems
		};

		// Manipulate Komponen	
		$('.btn-add').removeClass('btn-success').addClass('btn-warning').text('Submit Edit Resep').attr('id', 'submitButton').removeAttr('type').click(function(e) {
			e.preventDefault();
			// var jsonString = JSON.stringify(formData);
			// console.log(jsonString);
			executeEditResep(formData);
		});
		$('.btn-info').prop('disabled', true);
		$('#nama').prop('disabled', true);
		$('select[name="menuName[]"]').prop('disabled', true);
		$('input[name="qty[]"]').prop('disabled', true);
		$('input[name="isBahanUtama"]').prop('disabled', true);
		$('button.btn-remove').prop('disabled', true);	
	});
}

function executeEditResep(data) {
	$.ajax({
		url: editUrl,
		type: "post",
		dataType: "json",
		data: data,
		success: (res) => {
			// console.log(res);
			$(".modal").modal("hide");
			Swal.fire("Sukses", "Sukses Mengedit Data", "success");
			reloadTable();
		},
		error: err => {
			console.log(err)
		}
	});
}

function add() {
    url = "add";
    $(".modal-title").html("Add Data");
    $('.modal button[type="submit"]').html("Create Resep");
	// Panggil fungsi untuk memuat data saat halaman dimuat
    loadDataToDropdown('#bahan','#satuan');
}

function edit(id) {
    $.ajax({
        url: getResepUrl,
        type: "post",
        dataType: "json",
        data: {
            id: id
        },
        success: res => {
			// console.log(res);
			$('#menuTable').find('tr:gt(0)').remove();
			$('#id').val(res.id_resep);
			$('#nama').val(res.nama_resep);
			var tc = parseInt(res.total_cost);
			var totalRupiah = tc.toLocaleString('id-ID', {
				style: 'currency',
				currency: 'IDR'
			});
			$('#cost').val(totalRupiah);

			res.bahan.forEach((bahan, index) => {
				// Membuat elemen <tr> baru untuk setiap bahan
				var newRow = $('<tr>');
				newRow.append('<td><div class="form-group"><select id="bahan'+index+'" class="form-control select2" name="menuName[]" required><option value="' + bahan.id_bahan + '">' + bahan.nama_bahan + '</option></select></div><input type="hidden" id="id_bahan_before" value="'+ bahan.id_bahan +'"></td>');
				newRow.append('<td><div style="display: flex; align-items: center;"> <div class="form-group" style="margin-right: 5px;"> <input class="form-control" type="number" name="qty[]" min="1" value="' + bahan.qty + '" required /></div><div><div class="col-auto align-self-center" id="satuan'+index+'">/ '+bahan.satuan+'</div></div></div></td>');
				newRow.append('<td><div class="form-group"><input type="radio" class="form-control" name="isBahanUtama" ' + (bahan.isBahanUtama == '1' ? 'checked' : '') + ' required /></div></td>');
				if (bahan.length === 1 || bahan.isBahanUtama == '1') {
					newRow.append('<td></td>');
				} else {
					newRow.append('<td><button class="btn btn-info btn-sm" type="button" onclick="removeRowEdit(this,' + res.id_resep + ')">Remove</button></td>');
				}
				
				// Menambahkan baris baru ke dalam tabel
				$('#menuTable').append(newRow);
				loadDataToDropdown('#bahan'+index, '#satuan'+index);
			});

            $(".modal").modal("show");
            $(".modal-title").html("Edit Data");
            $('.modal button[type="submit"]').html("Edit");
            url = "edit";
        },
        error: err => {
            console.log(err)
        }
    });
}

resep.on("order.dt search.dt", () => {
    resep.column(0, {
        search: "applied",
        order: "applied"
    }).nodes().each((el, val) => {
        el.innerHTML = val + 1
    });
});

$("#form").validate({
    errorElement: "span",
    errorPlacement: (err, el) => {
        err.addClass("invalid-feedback");
        el.closest(".form-group").append(err);
    },
    submitHandler: () => {
        "edit" == url ? editData() : addData()
    }
});

$("#kategori").select2({
    placeholder: "Kategori",
    ajax: {
        url: kategoriSearchUrl,
        type: "post",
        dataType: "json",
        data: params => ({
            kategori: params.term
        }),
        processResults: data => ({
            results: data
        }),
        cache: true
    }
});

$(".modal").on("hidden.bs.modal", () => {
	//Add Resep to Default
    // $("#form")[0].reset();
    // $("#form").validate().resetForm();
	// $('.btn-add').removeClass('btn-warning').addClass('btn-success').text('Create Resep');
	// $('#nama').prop('disabled', false);
	// $('select[name="menuName[]"]').prop('disabled', false);
	// $('input[name="qty[]"]').prop('disabled', false);
	// $('input[name="isBahanUtama"]').prop('disabled', false);
	// $('button.btn-remove').prop('disabled', false);
	// $('#menuTable').find('tr:gt(0)').remove();
	// var menuItemsPromises = [];
	location.reload();
});
