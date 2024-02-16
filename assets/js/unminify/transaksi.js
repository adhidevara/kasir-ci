let isCetak = false,
    produk = [],
    transaksi = $("#transaksi").DataTable(console.log(produk),{
        responsive: true,
        lengthChange: false,
        searching: false,
        scrollX: true
    });

function reloadTable() {
    transaksi.ajax.reload()
}

function nota(jumlah) {
    let hasil = "",
        char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
        total = char.length;
    for (var r = 0; r < jumlah; r++) hasil += char.charAt(Math.floor(Math.random() * total));
    return hasil
}

function getNama() {
    $.ajax({
        url: produkGetNamaUrl,
        type: "post",
        dataType: "json",
        data: {
            id: $("#barcode").val()
        },
        success: res => {
            $("#nama_produk").html(res.nama_produk);
            $("#sisa").html(`Sisa ${res.stok}`);
            checkEmpty()
        },
        error: err => {
            console.log(err)
        }
    })
}

function checkStok(id,index) {
    $.ajax({
        url: produkGetStokUrl,
        type: "post",
        dataType: "json",
        data: {
            id: id
        },
        success: res => {
            let barcode = id,
                nama_produk = res.nama_produk,
                jumlah = parseInt($("#jumlah"+index).val()),
                stok = parseInt(res.stok),
                harga = parseInt(res.harga),
                dataBarcode = res.barcode,
                total = parseInt($("#total").html());
            if (stok <= jumlah || stok === 0 || jumlah === 0) Swal.fire("Gagal", "Stok Tidak Cukup", "warning");
            else {
                let a = transaksi.rows().indexes().filter((a, t) => dataBarcode === transaksi.row(a).data()[0]);
                if (a.length > 0) {
                    let row = transaksi.row(a[0]),
                        data = row.data();
                    if (stok < data[3] + jumlah) {
                        Swal.fire('stok', "Stok Tidak Cukup", "warning")
                    } else {
                        data[3] = data[3] + jumlah;
                        row.data(data).draw();
                        indexProduk = produk.findIndex(a => a.id == barcode);
                        produk[indexProduk].stok = stok - data[3];
                        $("#total").html(total + harga * jumlah)
                    }
                } else {
                    produk.push({
                        id: barcode,
                        stok: stok - jumlah,
                        terjual: jumlah,
						qty: parseInt($("#jumlah"+index).val())
                    });
                    transaksi.row.add([
                        dataBarcode,
                        nama_produk,
                        harga,
                        jumlah,
                        `<button name="${barcode}" class="btn btn-sm btn-danger" onclick="remove('${barcode}')">Hapus</btn>`]).draw();
                    $("#total").html(total + harga * jumlah);
                    $("#jumlah"+index).val("0");
                    $("#tambah").attr("disabled", "disabled");
                    $("#bayar").removeAttr("disabled")
                } 
            }
        }
    })
}

function bayarCetak() {
    isCetak = true
}

function bayar() {
    isCetak = false
}

function checkEmpty() {
    let barcode = $("#barcode").val(),
        jumlah = $("#jumlah").val();
    if (barcode !== "" && jumlah !== "" && parseInt(jumlah) >= 1) {
        $("#tambah").removeAttr("disabled")    
    } else {
        $("#tambah").attr("disabled", "disabled")
    }
}

function checkUang() {
    let jumlah_uang = $('[name="jumlah_uang"').val(),
        total_bayar = parseInt($(".total_bayar").html());
    if (jumlah_uang !== "" && jumlah_uang >= total_bayar) {
        $("#add").removeAttr("disabled");
        $("#cetak").removeAttr("disabled")
    } else {
        $("#add").attr("disabled", "disabled");
        $("#cetak").attr("disabled", "disabled")
    }
}

function remove(nama) {
    let data = transaksi.row($("[name=" + nama + "]").closest("tr")).data(),
        stok = data[3],
        harga = data[2],
        total = parseInt($("#total").html());
        akhir = total - stok * harga
    $("#total").html(akhir);
    transaksi.row($("[name=" + nama + "]").closest("tr")).remove().draw();
    $("#tambah").attr("disabled", "disabled");
    if (akhir < 1) {
        $("#bayar").attr("disabled", "disabled")
    }
}

function add() {
    let data = transaksi.rows().data(),
        qty = [];
    $.each(data, (index, value) => {
        qty.push(value[3])
    });
    $.ajax({
        url: addUrl,
        type: "post",
        dataType: "json",
        data: {
            produk: JSON.stringify(produk),
            tanggal: $("#tanggal").val(),
            qty: qty,
            total_bayar: $("#total").html(),
            jumlah_uang: $('[name="jumlah_uang"]').val(),
            diskon: $('[name="diskon"]').val(),
            pelanggan: $("#pelanggan").val(),
            nota: $("#nota").html()
        },
        success: res => {
            if (isCetak) {
                Swal.fire("Sukses", "Sukses Membayar", "success").
                    then(() => window.location.href = `${cetakUrl}${res}`)
            } else {
                Swal.fire("Sukses", "Sukses Membayar", "success").
                    then(() => window.location.reload())
            }
        },
        error: err => {
            console.log(err)
        }
    })
}

function kembalian() {
    let total = $("#total").html(),
        jumlah_uang = $('[name="jumlah_uang"').val(),
        diskon = $('[name="diskon"]').val();
    $(".kembalian").html(jumlah_uang - total - diskon);
    checkUang()
}

$(document).ready(function() {
    // Lakukan request AJAX ke backend untuk mengambil data
    $.ajax({
        url: getBarcodeUrl, // Ganti dengan URL backend Anda
        method: 'post', // Sesuaikan dengan metode yang digunakan untuk mengambil data (GET, POST, dll.)
        success: function(data) {
            // console.log(data);
            // Selector elemen <div> dengan ID "prodCard"
            var $prodCard = $("#prodCard");

            // Melakukan looping sebanyak data yang diterima dari backend <img id='img_produk' src='`+item.imageUrl+`' class='card-img-top' alt='Produk`+index+`'></img>
            $.each(data, function(index, item) {           
                let html = `
                <div class='col-md-2'>
                    <div class='card shadow'>
                        <div class='card-body'>
                            <h5 class='card-title text-bold' id='nama_produk`+index+`'>`+item.text+`</h5><br>
                            <small class='card-text' id='stock'>Stok : `+item.stok+item.satuanText+`</small>
                            <p class='card-text text-bold'>Rp.`+item.harga+`</p>
                            <div class='input-group mb-3'>
                                <div class='input-group-prepend'>
                                    <button class='btn btn-outline-secondary' type='button' id='minusBtn`+index+`'>-</button>
                                </div>
                                <input type='number' class='form-control' id='jumlah`+index+`' value='0' onkeyup='checkEmpty()'>
                                <div class='input-group-append'>
                                    <button class='btn btn-outline-secondary' type='button' id='plusBtn`+index+`'>+</button>
                                </div>
                            </div>
                            <div class='form-group'>
                            <button class='btn btn-success' id='tambah`+index+`' onclick='checkStok(`+item.id+`,`+index+`)'>Tambah</button>
                            </div>  
                        </div>
                    </div>
                </div>`;
                
                $("#prodCard").append(html);

                // Menambahkan event listener untuk tombol plus dan minus
                $("#plusBtn"+index).on("click", function() {
                    var $input = $(this).closest(".input-group").find("#jumlah"+index);
                    var currentValue = parseInt($input.val());
                    $input.val(currentValue + 1);
                });

                $("#minusBtn"+index).on("click", function() {
                    var $input = $(this).closest(".input-group").find("#jumlah"+index);
                    var currentValue = parseInt($input.val());
                    if (currentValue > 0) {
                        $input.val(currentValue - 1);
                    }
                });
            });
        },
        error: function() {
            // Handle error jika request AJAX gagal
            console.log("Gagal mengambil data dari backend.");
        }
    });
});

$("#barcode").select2({
    placeholder: "Barcode",
    ajax: {
        url: getBarcodeUrl,
        type: "post",
        dataType: "json",
        data: params => ({
            barcode: params.term
        }),
        processResults: res => ({
            results: res
        }),
        cache: true
    }
});
$("#pelanggan").select2({
    placeholder: "Pelanggan",
    ajax: {
        url: pelangganSearchUrl,
        type: "post",
        dataType: "json",
        data: params => ({
            pelanggan: params.term
        }),
        processResults: res => ({
            results: res
        }),
        cache: true
    }
});
$("#tanggal").datetimepicker({
    format: "dd-mm-yyyy h:ii:ss"
});
$(".modal").on("hidden.bs.modal", () => {
    $("#form")[0].reset();
    $("#form").validate().resetForm()
});
$(".modal").on("show.bs.modal", () => {
    let now = moment().format("D-MM-Y H:mm:ss"),
        total = $("#total").html(),
        jumlah_uang = $('[name="jumlah_uang"').val();
    $("#tanggal").val(now), $(".total_bayar").html(total), $(".kembalian").html(Math.max(jumlah_uang - total, 0))
});
$("#form").validate({
    errorElement: "span",
    errorPlacement: (err, el) => {
        err.addClass("invalid-feedback"), el.closest(".form-group").append(err)
    },
    submitHandler: () => {
        add()
    }
});
$("#nota").html(nota(15));
